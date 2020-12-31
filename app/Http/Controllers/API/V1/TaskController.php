<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\V1\TaskCollection;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return TaskCollection
     */
    public function index()
    {
        return new TaskCollection(Task::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TaskRequest $request
     * @return Task
     */
    public function store(TaskRequest $request): Task
    {
        $task = new Task;
        $task->name = $request->get('name');
        $task->save();

        return $task;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return string
     */
    public function show(int $id)
    {
        $task = Task::find($id);

        if ($task) {
            return $task;
        } else {
            return 'Task not found';
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return string
     */
    public function update(Request $request, $id): string
    {
        $task = Task::withTrashed()->find($id);

        if ($task) {
            $task->delete();

            return $task;
        } else {
            return 'Task not found';
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return string
     */
    public function destroy($id): string
    {
        $task = Task::withTrashed()->find($id);

        if ($task) {
            $task->forceDelete();

            return 'Task deleted';
        } else {
            return 'Task not found';
        }
    }
}
