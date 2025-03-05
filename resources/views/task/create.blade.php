<x-app-layout>
    <section class="bg-white dark:bg-gray-900">
        <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
            <div class="grid col-span-full">
                <h1 class="mb-5">{{ __('task.createTask') }}</h1>

                <form class="w-50" method="POST" action="{{ route('task.create') }}">
                    @csrf
                    <div class="flex flex-col">
                        <div>
                            <label for="name">{{ __('task.name') }}</label>
                        </div>
                        <div class="mt-2">
                            <input class="rounded border-gray-300 w-1/3" type="text" name="name" id="name" value="{{ old('name') }}">
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        <div class="mt-2">
                            <label for="description">{{ __('task.description') }}</label>
                        </div>
                        <div>
                            <textarea class="rounded border-gray-300 w-1/3 h-32" name="description" id="description"></textarea>
                        </div>
                        <div class="mt-2">
                            <label for="status_id">{{ __('task.status') }}</label>
                        </div>
                        <div>
                            <select class="rounded border-gray-300 w-1/3" name="status_id" id="status_id">
                                <option value selected="selected"></option>
                                @foreach($task_statuses as $status)
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <x-input-error :messages="$errors->get('status_id')" class="mt-2" />
                        <div class="mt-2">
                            <label for="status_id">{{ __('task.executor') }}</label>
                        </div>
                        <div>
                            <select class="rounded border-gray-300 w-1/3" name="assigned_to_id" id="assigned_to_id">
                                <option value selected="selected"></option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-2">
                            <label for="status_id">{{ __('task.tags') }}</label>
                        </div>
                        <div>
                            <select class="rounded border-gray-300 w-1/3 h-32" name="labels[]" id="labels[]" multiple>
                                @foreach($labels as $label)
                                    <option value="{{ $label->id }}">{{ $label->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-2">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">{{ __('task.create') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-app-layout>
