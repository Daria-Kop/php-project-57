@props(['messages'])

@if ($messages)
    <div class="font-medium text-red-600">
        Упс! Что-то пошло не так:
    </div>
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1 mb-3 error-list']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
