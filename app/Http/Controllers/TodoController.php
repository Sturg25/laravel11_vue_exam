<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;
use App\Models\User;

class TodoController extends Controller
{
    //
    public function getList(Request $request)
    {
        $list = Todo::where("user_id", $request->id)->get();
        return response()->json($list);
    }
    public function addTodo(Request $request)
    {

        $fields = $request->validate([
            'description' => 'required|string',
        ]);
        $fields = $fields + ["user_id" => $request->id];

        $todo = Todo::create($fields);
        return response()->json($todo);
    }
    public function updateTodo(Request $request) {
        $todo = Todo::find($request->id);

        $todo->status = $request->status;

        $todo->save();
    }
    public function deleteTodo(Request $request)
    {
        $todo = Todo::find($request->id);

        $todo->delete();
    }
}
