<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return response()->json(Task::all(), 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'description' => 'required|string|max:255',
            'due_date' => 'nullable|date',
            'is_done' => 'boolean',
        ]);

        $task = Task::create($validatedData);

        return response()->json($task, 201);
    }


    public function update(Request $request, $id)
    {

        $task = Task::find($id);


        if (!$task) {
            return response()->json(['error' => 'Task não encontrada'], 404);
        }


        $validatedData = $request->validate([
            'description' => 'string|max:255',
            'due_date' => 'nullable|date',
            'is_done' => 'boolean',
        ]);

        $task->update($validatedData);

        return response()->json($task, 200);
    }

    public function destroy($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['error' => 'Task não encontrada'], 404);
        }

        $task->delete();

        return response()->json(null, 204);
    }
}
