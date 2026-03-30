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
        ]);

        AssistantTask::query()->create([
            'user_id' => $request->user()->getKey(),
            'title' => $data['title'],
            'category' => $data['category'],
            'priority' => 0,
            'sort_order' => 0,
        ]);

        return back();
    }

    public function toggleComplete(Request $request, AssistantTask $task): RedirectResponse
    {
        $task->completed_at = $task->completed_at ? null : CarbonImmutable::now();
        $task->save();

        return back();
    }
}
