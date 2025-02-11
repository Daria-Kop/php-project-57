<x-app-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csrf-param" content="_token" />
    <section class="bg-white dark:bg-gray-900">
        <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
                @include('flash::message')
            <div class="grid col-span-full">
                <h1 class="mb-5">{{ __('label.labels') }}</h1>
                @if (Auth::check())
                    <div>
                        <a href="{{ route('label.build') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">
                            {{ __('label.createLabel') }}
                        </a>
                    </div>
                @endif
                <table class="mt-4">
                    <thead class="border-b-2 border-solid border-black text-left">
                    <tr>
                        <th>{{ __('label.id') }}</th>
                        <th>{{ __('label.name') }}</th>
                        <th>{{ __('label.description') }}</th>
                        <th>{{ __('label.dateCreation') }}</th>
                        @if (Auth::check())
                            <th>{{ __('label.actions') }}</th>
                        @endif
                    </tr>
                    </thead>
                    @foreach($labels as $label)
                        <tr class="border-b border-dashed text-left">
                            <td>{{ $label->id }}</td>
                            <td>{{ $label->name }}</td>
                            <td>{{ $label->description }}</td>
                            <td>{{ $label->created_at }}</td>
                            @if (Auth::check())
                                <td>
                                    <a
                                        data-confirm="Вы уверены?"
                                        data-method="delete"
                                        class="text-red-600 hover:text-red-900"
                                        href="{{ route('label.destroy', ['label' => $label]) }}">
                                        {{ __('label.delete') }}
                                    </a>
                                    <a class="text-blue-600 hover:text-blue-900" href="{{ route('label.edit', ['label' => $label]) }}">
                                        {{ __('label.edit') }}
                                    </a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </section>
</x-app-layout>
