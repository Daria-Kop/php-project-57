<header class="fixed w-full">
<nav class="bg-white border-gray-200 py-2.5 dark:bg-gray-900 shadow-md">
    <div class="flex flex-wrap items-center justify-between max-w-screen-xl px-4 mx-auto">
        <a href="{{ route('dashboard') }}">
            <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">{{ __('other.logo') }}</span>
        </a>
        @if (Auth::check())
            <div class="flex items-center lg:order-2">
                <a
                    data-method="POST"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2"
                    href="{{ route('logout') }}">
                    {{ __('other.exit') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    <input type="hidden" name="_token" value="{{ csrf_field() }}" autocomplete="off">
                </form>
                @csrf
            </div>
        @else
        <div class="flex items-center lg:order-2">
            <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('other.login') }}
            </a>
            <a href="{{ route('register') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">
                {{ __('other.registration') }}
            </a>
        </div>
        @endif

        <div class="items-center justify-between hidden w-full lg:flex lg:w-auto lg:order-1">
            <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                <li>
                    <a href="{{ route('task.index') }}" class="block py-2 pl-3 pr-4 text-gray-700 hover:text-blue-700 lg:p-0">
                        {{ __('other.tasks') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('status.index') }}" class="block py-2 pl-3 pr-4 text-gray-700 hover:text-blue-700 lg:p-0">
                        {{ __('other.statuses') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('label.index') }}" class="block py-2 pl-3 pr-4 text-gray-700 hover:text-blue-700 lg:p-0">
                        {{ __('other.tags') }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
</header>
