<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index() {
        $task = Task::all();
        return response()->json($task, 200);
    }

    public function store(Request $request) {
       $task = Task::create([
        'title' => $request->input('title'),
        'description' => $request->input('description')
       ]);

       return response()->json($task, 201);
    }

    public function show($id) {
        $task = Task::find($id);

        if(! $task) {
            return response()->json([
                'message' => 'Task Tidak Ditemukan'
            ], 404);
        }

        return response()->json($task);
    }
}
