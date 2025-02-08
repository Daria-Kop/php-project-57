@extends('layouts.app')

@section('content')
    <x-h1>{{ __('Изменение метки') }}</x-h1>

    {{ html()->modelForm($label, 'PATCH', route('labels.update', $label))->open() }}
    @include('labels.form')
    {{ html()->submit( __('Обновить') )->class('btn-primary') }}
    {{ html()->closeModelForm() }}
@endsection
