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
        $priority = $request->query('priority');
        $priority = is_numeric($priority) ? (int) $priority : null;

        $tasksQuery = AssistantTask::query()
            ->forUser($user)
            ->whereDate('created_at', $today);

        $total = (clone $tasksQuery)->count();
        $completed = (clone $tasksQuery)->whereNotNull('completed_at')->count();

        $percent = $total === 0 ? 0 : (int) round(($completed / $total) * 100);

        $tasks = AssistantTask::query()
            ->forUser($user)
            ->when($priority !== null, fn ($q) => $q->where('priority', $priority))
            ->orderBy('priority', 'desc')
            ->orderBy('sort_order')
            ->latest('id')
            ->limit(60)
            ->get();

        $todo = $tasks->where('status', AssistantTask::STATUS_TODO);
        $inProgress = $tasks->where('status', AssistantTask::STATUS_IN_PROGRESS);
        $done = $tasks->where('status', AssistantTask::STATUS_DONE);

        return view('dashboard.index', [
            'percent' => $percent,
            'tasks' => $tasks,
            'todo' => $todo,
            'inProgress' => $inProgress,
            'done' => $done,
            'priority' => $priority,
        ]);
    }
}
