<x-app-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csrf-param" content="_token" />
    <section class="bg-white dark:bg-gray-900">
        <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
            @include('flash::message')
            <div class="grid col-span-full">
                <h1 class="mb-5">{{ __('task.tasks') }}</h1>
                <div class="w-full flex items-center">
                    <div>
                        <form method="GET" action="{{ route('task.index') }}">
                            <div class="flex">
                                <select class="rounded border-gray-300" name="filter[status_id]" id="filter[status_id]">
                                    <option value selected="selected">{{ __('task_status.status') }}</option>
                                    @foreach($taskStatuses as $taskStatus)
                                        <option value="{{ $taskStatus->id }}"
                                            @if($statusId === $taskStatus->id)
                                                selected="selected"
                                            @endif
                                        >{{ $taskStatus->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <select class="rounded border-gray-300" name="filter[created_by_id]" id="filter[created_by_id]">
                                    <option value selected="selected">{{ __('task.author') }}</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}"
                                            @if($createdId === $user->id)
                                            selected="selected"
                                            @endif
                                        >{{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <select class="rounded border-gray-300" name="filter[assigned_to_id]" id="filter[assigned_to_id]">
                                    <option value selected="selected">{{ __('task.executor') }}</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}"
                                            @if($assignedId === $user->id)
                                                selected="selected"
                                            @endif
                                        >{{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2" type="submit">{{ __('task.apply') }}</button>
                            </div>
                        </form>
                    </div>
                @if (Auth::check())
                    <div class="ml-auto">
                        <a href="{{ route('task.build') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">
                            {{ __('task.createTask') }}
                        </a>
                    </div>
                @endif
                </div>
                <table class="mt-4">
                    <thead class="border-b-2 border-solid border-black text-left">
                    <tr>
                        <th>{{ __('task.id') }}</th>
                        <th>{{ __('task.status') }}</th>
                        <th>{{ __('task.name') }}</th>
                        <th>{{ __('task.author') }}</th>
                        <th>{{ __('task.executor') }}</th>
                        <th>{{ __('task.dateCreate') }}</th>
                        @if (Auth::check())
                            <th>{{ __('task_status.actions') }}</th>
                        @endif
                    </tr>
                    </thead>
                    @foreach($tasks as $task)
                        <tr class="border-b border-dashed text-left">
                            <td>{{ $task->id }}</td>
                            <td>{{ $task->status->name }}</td>
                            <td>
                                <a
                                    class="text-blue-600 hover:text-blue-900"
                                    href="{{ route('task.show', ['task' => $task]) }}">
                                    {{ $task->name }}
                                </a>
                            </td>
                            <td>{{ $task->creator->name }}</td>
                            <td>{{ $task->executer->name ?? '' }}</td>
                            <td>{{ $task->created_at }}</td>

                                <td>
                                    @if (Auth::id() === $task->creator->id)
                                    <a
                                        data-confirm="Вы уверены?"
                                        data-method="delete"
                                        class="text-red-600 hover:text-red-900"
                                        href="{{ route('task.destroy', ['task' => $task]) }}">
                                        {{ __('task.delete') }}
                                    </a>
                                    @endif
                            @if (Auth::check())
                                    <a class="text-blue-600 hover:text-blue-900" href="{{ route('task.edit', ['task' => $task]) }}">
                                        {{ __('task_status.edit') }}
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
