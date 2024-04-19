<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return response()->json(Task::get());
        return response()->json(TaskResource::collection(Task::get()));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'done' => 'required|boolean'
        ]);
        try {
            $task = Task::create($request->all());
            return response()->json(new TaskResource($task), 201);

        } catch (Exception $exception) {
            return response()->json([
                'success' => 'false',
                'message' => $exception->getMessage(),
            ], $exception->getCode());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        try {
            $task->done = !$task->done;
            $task->save();
            return response()->json(new TaskResource($task));
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], $exception->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        try {
            $task->delete();
            return response()->json([
                'success' => true,
                'message' => 'Your task has been deleted successfully.'
            ], 200);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], $exception->getCode());
        }
    }
}
