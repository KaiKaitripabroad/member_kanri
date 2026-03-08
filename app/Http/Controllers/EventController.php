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
        return view('events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'event_date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'location' => 'nullable|string|max:200',
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
        return view('events.show', compact('event'));
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
