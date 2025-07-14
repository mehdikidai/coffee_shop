<?php

namespace App\Http\Controllers\web;

use App\Models\UserLogin;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;

class UserActivityLogController extends Controller
{
    public function index(Request $request): View
    {

        $search = trim((string) $request->input('search'));
        $activityLogQuery = UserLogin::with('user')->latest();

        if ($search !== '') {
            $activityLogQuery->whereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', "%$search%");
            })->orWhere('browser', 'like', "%$search%")
                ->orWhere('os', 'like', "%$search%");
        }

        $pagination_limit = pagination_limit();
        $logs = $activityLogQuery->paginate($pagination_limit)->appends(['search' => $search]);
        return view('user-activity-logs', compact('logs'));

    }
}
