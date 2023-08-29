<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;


class TaskController extends Controller
{
    use ApiResponser;

    public function index(Request $request)
    {
        if ($request->has('search') && $request->search != '') {

            $tasks =  Task::with('user', 'category')->where('title', 'LIKE', '%' . $request->search  . '%')
                ->orWhere('description', 'LIKE', '%' . $request->search  . '%')->get()->toArray();
        } else {
            $tasks = Task::with('user', 'category')->latest()->get()->toArray();
        }


        return $this->showOne($tasks, 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => ['required',  'string', 'min:3', 'max:50'],
            'description' => ['required',  'string', 'min:3', 'max:255'],
            'category_id' => ['nullable',  'string'],
            'due_date' => ['required',  'string']
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'user_id' => auth()->user()->id,
            'due_date' => $request->due_date
        ]);

        if ($task) {
            return response()->json([
                'status' => (bool)$task,
                'data' => $task,
                'message' => $task ? 'Task Created!' : 'Error Creating Task'
            ]);
        }


        return $this->errorResponse("Something went wrong please try again", 400);
    }

    public function show(Task $task)
    {
        return response()->json($task);
    }

    public function update(Request $request, Task $task)
    {
        $status = $task->update(
            $request->only(['title', 'category_id', 'user_id', 'due_date'])
        );

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Task Updated!' : 'Error Updating Task'
        ]);
    }

    public function destroy(Task $task)
    {
        $status = $task->delete();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Task Deleted!' : 'Error Deleting Task'
        ]);
    }
}
