<?php

namespace App\Http\Controllers;

use App\Models\AssistantTask;
use Carbon\CarbonImmutable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class AssistantTaskController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:32'],
            'priority' => ['nullable', 'integer', 'min:0', 'max:3'],
        ]);

        AssistantTask::query()->create([
            'user_id' => $request->user()->getKey(),
            'title' => $data['title'],
            'category' => $data['category'],
            'priority' => (int) ($data['priority'] ?? 0),
            'status' => AssistantTask::STATUS_TODO,
            'sort_order' => 0,
        ]);

        return back();
    }

    public function toggleComplete(Request $request, AssistantTask $task): RedirectResponse
    {
        $isCompleting = $task->completed_at === null;

        $task->completed_at = $isCompleting ? CarbonImmutable::now() : null;
        $task->status = $isCompleting ? AssistantTask::STATUS_DONE : AssistantTask::STATUS_TODO;
        $task->save();

        return back();
    }
}
