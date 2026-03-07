<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ここで定義する左側の名前を Blade と合わせる
        $totalMembers = \App\Models\Member::count();
        $newJoins = \App\Models\Member::whereMonth('created_at', now()->month)->count();
        $unconfirmed = 1;
        $recentUpdates = \App\Models\Member::latest()->take(3)->get();

        // compactの中身も一致させる
        return view('dashboard', compact('totalMembers', 'newJoins', 'unconfirmed', 'recentUpdates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        //
    }
}
