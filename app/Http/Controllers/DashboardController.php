<?php

namespace App\Http\Controllers;

use App\Models\AssistantTask;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        $today = CarbonImmutable::today();

        $tasksQuery = AssistantTask::query()
            ->forUser($user)
            ->whereDate('created_at', $today);

        $total = (clone $tasksQuery)->count();
        $completed = (clone $tasksQuery)->whereNotNull('completed_at')->count();

        $percent = $total === 0 ? 0 : (int) round(($completed / $total) * 100);

        $tasks = AssistantTask::query()
            ->forUser($user)
            ->orderByRaw('completed_at is not null')
            ->orderBy('sort_order')
            ->latest('id')
            ->limit(12)
            ->get();

        return view('dashboard.index', [
            'percent' => $percent,
            'tasks' => $tasks,
            'todo' => $tasks->whereNull('completed_at'),
            'done' => $tasks->whereNotNull('completed_at'),
        ]);
    }
}
