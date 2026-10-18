<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index() {
        $tasks = Task::all();
        return response()->json([
            'message' => 'Task Berhasil Ditampilkan',
            'data' => TaskResource::collection($tasks)
        ], 200);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $task = Task::create($validated);

       return response()->json([
        'message' => 'Task Berhasil Dibuat',
        'data' => new TaskResource($task) 
       ], 201);
    }

    public function show($id) {
        $task = Task::find($id);

        if(! $task) {
            return response()->json([
                'message' => 'Task Tidak Ditemukan'
            ], 404);
        }

        return response()->json([
            'message' => 'Task Berhasil Ditemukan',
            'data' => new TaskResource($task)
        ], 200);
    }

    public function update(Request $request, $id) {
        $task = Task::find($id);

        if (! $task) {
            return response()->json([
                'message' => 'Task Tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'is_completed' => 'boolean'
        ]);

        $task->update($validated);

        return response()->json([
            'message' => 'Task Berhasil Di Perbarui',
            'data' => new TaskResource($task)
        ], 200);
    }

    public function destroy($id) {
        $task = Task::find($id);

        if (! $task) {
            return response()->json([
                'message' => 'Task Tidak Ditemukan',
            ], 404);
        }

        $task->delete();

        return response()->json([
            'message' => 'Task berhasil dihapus'
        ]);
    }
}
