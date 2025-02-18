@extends('layouts.app')

@section('content')
    <x-h1>{{ __('Изменение задачи') }}</x-h1>

    {{ html()->modelForm($task, 'PATCH', route('tasks.update', $task))->id('taskForm')->open() }}
    @include('tasks.form')
    {{ html()->submit( __('Обновить') )->class('btn-primary') }}
    {{ html()->closeModelForm() }}
@endsection
