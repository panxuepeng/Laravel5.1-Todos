@extends('main')

@section('content')
    <h1>Todos</h1>
    <input id="new-todo" type="text" placeholder="What needs to be done?">
    <ol id="list">
    @foreach ($todos as $todo)
        <li>
            <span class="title status-{{ $todo->status }}">{{ $todo->title }}</span>
            <span class="edit">
                <a data-type="ok" data-id="{{ $todo->id }}">搞定</a>
                <a data-type="delete" data-id="{{ $todo->id }}">删除</a>
            </span>
        </li>
    @endforeach        
    </ol>
@stop