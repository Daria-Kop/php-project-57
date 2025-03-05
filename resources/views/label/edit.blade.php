<x-app-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csrf-param" content="_token" />
<section class="bg-white dark:bg-gray-900">
    <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
        <div class="grid col-span-full">
            <h1 class="mb-5">{{ __('label.editLabel') }}</h1>

            <form class="w-50" method="POST" action="{{ route('label.update', ['label' => $label]) }}"><input type="hidden" name="_method" id="_method" value="PATCH"><input type="hidden" name="_token" value="Tw7wlFDqDKn0eGHb8K6rd3cpE0ilVhY36dUeiC9R">
                <div class="flex flex-col">
                    <div>
                        <label for="name">{{ __('label.name') }}</label>
                    </div>
                    <div class="mt-2">
                        <input class="rounded border-gray-300 w-1/3" type="text" name="name" id="name" value="{{ $label->name }}">
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    <div class="mt-2">
                        <label for="description">{{ __('label.description') }}</label>
                    </div>
                    <div class="mt-2">
                        <textarea class="rounded border-gray-300 w-1/3 h-32" name="description" id="description">{{ $label->description }}</textarea>
                    </div>
                    <div class="mt-2">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">{{ __('label.update') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
</x-app-layout>
