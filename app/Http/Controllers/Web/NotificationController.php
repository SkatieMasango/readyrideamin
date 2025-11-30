<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Driver;
use App\Models\Rider;
use App\Models\User;
use App\Services\NotificationServices;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function announcements(Request $request): View
    {
        $perPage = $request->query('per_page', 10);
        $data = Announcement::paginate($perPage);

        $users = User::all()->map(fn($user) => [
            'value' => $user->id,
            'name' => $user->name ,
        ]);

        return view('notification.announcements', compact('data','users'));
    }

    public function announcementStore(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string',
        'body' => 'required|string',
        'type' => 'nullable|in:all,drivers,riders',
        'user_ids' => 'nullable|array',
    ]);

    $validated['user_ids'] = array_map('intval', $request->user_ids ?? []);

    Announcement::create($validated);

    $tokens = [];

    if (!empty($validated['user_ids'])) {
        $tokens = User::whereIn('id', $validated['user_ids'])
            ->whereNotNull('device_token')
            ->pluck('device_token')
            ->toArray();

    } elseif ($validated['type'] === 'drivers') {
        $tokens = User::where('role', 'driver')
            ->whereNotNull('device_token')
            ->pluck('device_token')
            ->toArray();

    } elseif ($validated['type'] === 'riders') {
        $tokens = User::where('role', 'rider')
            ->whereNotNull('device_token')
            ->pluck('device_token')
            ->toArray();

    } else {
        $tokens = User::whereNotNull('device_token')
            ->pluck('device_token')
            ->toArray();
    }

    if (!empty($tokens)) {
        $title = $validated['title'];
        $body = $validated['body'];

        NotificationServices::sendNotification($body, $tokens, $title);
    }

    return redirect()->route('announcements.index')->with('success', 'Announcement created and notification sent successfully!');
}


    public function getUsersByType($type)
{

    if ($type === 'drivers') {
        $users = Driver::with('user')->get();
    } elseif ($type === 'riders') {
        $users = Rider::with('user')->get();
    } elseif($type === 'all') {
        $users = User::all();
    }

    $formatted = $users->map(function ($user) {
        $name = $user->name ?? ($user->user->name ?? 'N/A');
        return [
            'value' => $user->user_id ?? $user->id,
            'name' => trim($name ),
        ];
    });

    return response()->json($formatted);
}



}
