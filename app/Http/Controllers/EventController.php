<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Event;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();

        $upcomingCount = Event::where('event_date', '>=', $today)->count();
        $pastCount = Event::where('event_date', '<', $today)->count();
        $totalCount = Event::count();

        $tab = $request->get('tab', 'upcoming');
        $query = Event::with('attendances')->orderBy('event_date', 'desc')->orderBy('start_time');

        if ($tab === 'upcoming') {
            $query->where('event_date', '>=', $today);
        } elseif ($tab === 'past') {
            $query->where('event_date', '<', $today);
        }

        $events = $query->get();

        return view('events.index', compact('events', 'upcomingCount', 'pastCount', 'totalCount', 'tab'));
    }

    public function create()
    {
        if (empty(Auth::user()->role)) {
            return redirect()->route('events.index')->with('error', '役職がある方のみイベントを投稿できます。プロフィールで役職を設定してください。');
        }
        return view('events.create');
    }

    public function store(Request $request)
    {
        if (empty(Auth::user()->role)) {
            return redirect()->route('events.index')->with('error', '役職がある方のみイベントを投稿できます。');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'event_date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'location' => 'nullable|string|max:200',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'description' => 'nullable|string',
            'attendance_enabled' => 'required|boolean',
        ]);

        $validated['created_by'] = Auth::id();

        $event = Event::create($validated);

        if ($event->attendance_enabled) {
            $members = Member::whereNull('deleted_at')->get();
            foreach ($members as $member) {
                Attendance::create([
                    'event_id' => $event->id,
                    'member_id' => $member->id,
                    'status' => Attendance::STATUS_PENDING,
                ]);
            }
        }

        return redirect()->route('events.index')->with('success', 'イベントを投稿しました');
    }

    public function show(Event $event)
    {
        $event->load(['attendances.member']);
        $attendingCount = $event->attendances->where('status', Attendance::STATUS_ATTENDING)->count();
        $notAttendingCount = $event->attendances->where('status', Attendance::STATUS_NOT_ATTENDING)->count();
        $pendingCount = $event->attendances->where('status', Attendance::STATUS_PENDING)->count();
        return view('events.show', compact('event', 'attendingCount', 'notAttendingCount', 'pendingCount'));
    }

    public function attendance(Event $event)
    {
        $event->load(['attendances.member']);
        return view('events.attendance', compact('event'));
    }

    public function updateAttendance(Request $request, Event $event)
    {
        $event->load('attendances');
        $request->validate(['attendances' => 'array', 'attendances.*' => 'in:ATTENDING,NOT_ATTENDING,PENDING']);
        foreach ($request->input('attendances', []) as $attendanceId => $status) {
            $att = $event->attendances->firstWhere('id', $attendanceId);
            if ($att && in_array($status, [Attendance::STATUS_ATTENDING, Attendance::STATUS_NOT_ATTENDING, Attendance::STATUS_PENDING], true)) {
                $att->update(['status' => $status]);
            }
        }
        return redirect()->route('events.attendance', $event)->with('success', '出欠を更新しました');
    }

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'event_date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'location' => 'nullable|string|max:200',
            'description' => 'nullable|string',
            'attendance_enabled' => 'required|boolean',
        ]);

        $event->update($validated);

        return redirect()->route('events.index')->with('success', 'イベントを更新しました');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')->with('success', 'イベントを削除しました');
    }
}
