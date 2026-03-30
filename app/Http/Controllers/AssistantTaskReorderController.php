<?php

namespace App\Http\Controllers;

use App\Models\AssistantTask;
use Carbon\CarbonImmutable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

final class AssistantTaskReorderController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $data = $request->validate([
            'columns' => ['required', 'array'],
            'columns.todo' => ['required', 'array'],
            'columns.in_progress' => ['required', 'array'],
            'columns.done' => ['required', 'array'],
            'columns.todo.*' => ['integer'],
            'columns.in_progress.*' => ['integer'],
            'columns.done.*' => ['integer'],
        ]);

        $userId = (int) $request->user()->getKey();

        /** @var array<string, array<int, int>> $columns */
        $columns = $data['columns'];

        $ids = array_values(array_unique(array_merge(
            $columns[AssistantTask::STATUS_TODO],
            $columns[AssistantTask::STATUS_IN_PROGRESS],
            $columns[AssistantTask::STATUS_DONE],
        )));

        $tasks = AssistantTask::query()->whereIn('id', $ids)->forUser($userId)->get()->keyBy('id');

        if ($tasks->count() !== count($ids)) {
            return response()->json(['message' => 'Invalid tasks payload'], 422);
        }

        DB::transaction(function () use ($columns, $tasks): void {
            $this->applyColumn($tasks, AssistantTask::STATUS_TODO, $columns[AssistantTask::STATUS_TODO], clearCompletedAt: true);
            $this->applyColumn($tasks, AssistantTask::STATUS_IN_PROGRESS, $columns[AssistantTask::STATUS_IN_PROGRESS], clearCompletedAt: true);
            $this->applyColumn($tasks, AssistantTask::STATUS_DONE, $columns[AssistantTask::STATUS_DONE], clearCompletedAt: false);
        });

        return response()->json(['ok' => true]);
    }

    /**
     * @param  \Illuminate\Support\Collection<int, AssistantTask>  $tasksById
     * @param  array<int, int>  $orderedIds
     */
    private function applyColumn($tasksById, string $status, array $orderedIds, bool $clearCompletedAt): void
    {
        foreach (array_values($orderedIds) as $index => $id) {
            /** @var AssistantTask $task */
            $task = $tasksById[(int) $id];

            $task->status = $status;
            $task->sort_order = $index;

            if ($status === AssistantTask::STATUS_DONE) {
                $task->completed_at = $task->completed_at ?? CarbonImmutable::now();
            } elseif ($clearCompletedAt) {
                $task->completed_at = null;
            }

            $task->save();
        }
    }
}

