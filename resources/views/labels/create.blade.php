@extends('layouts.app')

@section('content')
    <x-h1>{{ __('Создать метку') }}</x-h1>

    {{ html()->modelForm($label, 'POST', route('labels.store', $label))->open() }}
    <input type="hidden" name="backUrl" value="{{ $backUrl }}">
    @include('labels.form')
    {{ html()->submit( __('Создать'))->class('btn-primary') }}
    {{ html()->closeModelForm() }}
@endsection
