<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Todo;
use Queue;
use App\Commands\SendCms;
use App\Events\AfterTodoDeleted;
use Cms;

class TodosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        $todos = Todo::all();
        
        return view('todos', compact('todos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postSave(Request $request)
    {
        $title = $request->input('title');
        
        $this->validate($request, [
            'title' => 'required|unique:todos|max:20'
        ], ['title.max'=>'标题长度不能超过:max']);
    
        $todo = new Todo;
        $todo->title = $title;
        $todo->save();
        
        //app('cms')->send("CMS: $title");
        Cms::send("CMS: $title");
        
        //Queue::push(new SendCms($title));
        
        return json_encode($todo);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function postOk(Request $request)
    {
        $id = $request->input('id');
        
        $todo = Todo::findOrFail($id);
        $todo->status = 1;
        $todo->save();
        
        return 'ok';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function postDelete(Request $request)
    {
        $id = $request->input('id');
        Todo::destroy($id);
        
        event(new AfterTodoDeleted($id));
        // log
        // email
        // cms
        
        
        return 'delete';
    }
}
