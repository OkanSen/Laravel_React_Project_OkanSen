<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;


class TaskController extends Controller
{
    // GET /api/tasks
    public function index()
    {
        //return response()->json(Task::all());
        return TaskResource::collection(Task::all());

    }

    // POST /api/tasks
    public function store(Request $request)
    {
        $task = Task::create($request->all());
        //return response()->json($task, 201);
        return new TaskResource($task);

    }

    // GET /api/tasks/{id}
    public function show($id)
    {
        return response()->json(Task::findOrFail($id));
    }

    // PUT /api/tasks/{id}
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->update($request->all());
        return response()->json($task);
    }

    // DELETE /api/tasks/{id}
    public function destroy($id)
    {
        Task::destroy($id);
        return response()->json(null, 204);
    }
}
