<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteTodoListRequest;
use App\Http\Requests\IndexTodoListRequest;
use App\Models\TodoList;
use App\Http\Requests\StoreTodoListRequest;
use App\Http\Requests\UpdateTodoListRequest;

class TodoListController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexTodoListRequest $request)
    {
        $user_id = $request->user_id;
        $data = TodoList::query()->where(
            'user_id',
            '=',
            $user_id
        )->get([
            'id',
            'title',
            'description',
            'user_id',
        ]);
        return $this->success($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTodoListRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTodoListRequest $request)
    {
        $data = $request->validated();
        $todo = TodoList::create($data);
        return $this->success($todo, trans('todo.create'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TodoList  $todoList
     * @return \Illuminate\Http\Response
     */
    public function show(TodoList $todoList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TodoList  $todoList
     * @return \Illuminate\Http\Response
     */
    public function edit(TodoList $todoList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTodoListRequest  $request
     * @param  \App\Models\TodoList  $todoList
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTodoListRequest $request, TodoList $todoList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TodoList  $todoList
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteTodoListRequest $request)
    {
        $arr = $request->validated();
        $todo_id = $arr['todo_id'];
        $user_id = $arr['user_id'];
        $todo = TodoList::query()->where([
            'user_id' => $user_id,
            'id' => $todo_id,
        ])->first();
        if (!empty($todo)) {
            $todo->delete();
            return $this->success([], trans('todo.delete_success'));
        } else {
            return $this->failure([], trans('todo.delete_fail'));
        }
    }
}
