<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use App\Models\Task;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Cache;

class TaskController extends Controller
{
    // GET /api/tasks - Get all tasks
    //public function index()
    //{
      //  $tasks = Task::all();
       // return response()->json($tasks);
    //}

    // GET /api/tasks - Get all tasks
    public function index()
    {
        $tasks = Cache::remember('tasks.all', 60, function () {
            return Task::all();
        });
        return response()->json($tasks);
    }

    // POST /api/tasks - Create a new task
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_completed' => 'boolean',
        ]);

        $task = Task::create($validated);
        return response()->json($task, 201);
    }

    // GET /api/tasks/{id} - Get a single task
    public function show(string $id)
    {
        $task = Task::findOrFail($id);
        return response()->json($task);
    }

    // PUT /api/tasks/{id} - Update a task
    public function update(Request $request, string $id)
    {
        $task = Task::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'is_completed' => 'boolean',
        ]);

        $task->update($validated);
        return response()->json($task);
    }

    // DELETE /api/tasks/{id} - Delete a task
    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return response()->json(null, 204);
    }
}
