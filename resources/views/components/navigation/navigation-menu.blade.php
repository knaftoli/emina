{{-- sidebar for mobile --}}
<div x-data="{ openSideBar: false }">
    <div class="relative z-50 lg:hidden" role="dialog" aria-modal="true" x-cloak x-show="openSideBar"
        x-transition.duration.300ms>
        <div class="fixed inset-0 bg-gray-900/80"></div>
        <div class="fixed inset-0 flex">
            <div class="relative mr-16 flex w-full max-w-xs flex-1">
                <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                    <button @@click="openSideBar = false" type="button" class="-m-2.5 p-2.5">
                        <span class="sr-only">Close sidebar</span>
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-2">
                    <div class="shrink-0 flex items-center pt-2">
                        <a href="{{ route('dashboard') }}">
                            <x-application-mark class="block h-9 w-auto" />
                        </a>
                    </div>
                    <nav class="flex flex-1 flex-col">
                        <ul role="list" class="flex flex-1 flex-col gap-y-7">
                            <li>
                                <ul role="list" class="-mx-2 space-y-1">
                                    <li>
                                        <x-navigation.nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                                            {{ __('Dashboard') }}
                                        </x-navigation.nav-link>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                {{-- admin nav --}}
                                <div class="text-xs font-semibold leading-6 text-gray-400">Admin Settings</div>
                                <ul role="list" class="-mx-2 mt-2 space-y-1">
                                    <li>
                                        <x-navigation.nav-link href="{{ route('admin.invited-emails') }}" :active="request()->routeIs('admin.invited-emails')">
                                            {{ __('Invited Emails') }}
                                        </x-navigation.nav-link>
                                    </li>
                                    <li>
                                        <x-navigation.nav-link href="{{ route('admin.roles') }}" :active="request()->routeIs('admin.roles')">
                                            {{ __('Roles') }}
                                        </x-navigation.nav-link>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    {{-- Static sidebar for desktop --}}
    <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-50 lg:flex-col">
        <div class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-gray-200 bg-white px-6">
            <div class="shrink-0 flex items-center pt-2">
                <a href="{{ route('dashboard') }}">
                    <x-application-mark class="block h-9 w-auto" />
                </a>
            </div>
            <nav class="flex flex-1 flex-col">
                <ul role="list" class="flex flex-1 flex-col gap-y-7">
                    <li>
                        <ul role="list" class="-mx-2 space-y-1">
                            <li>
                                <x-navigation.nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                                    <x-wui-icon name="home" class="h-6 w-6" />
                                    {{ __('Dashboard') }}
                                </x-navigation.nav-link>
                            </li>
                        </ul>
                    </li>
                    <li>
                        {{-- admin nav --}}
                        <div class="text-xs font-semibold leading-6 text-blue-600">
                            Admin Menue
                        </div>
                        <ul role="list" class="-mx-2 mt-2 space-y-1">
                            <li>
                                <x-navigation.nav-link href="{{ route('admin.invited-emails') }}" :active="request()->routeIs('admin.invited-emails')">
                                    {{ __('Invited Emails') }}
                                </x-navigation.nav-link>
                            </li>
                            <li>
                                <x-navigation.nav-link href="{{ route('admin.roles') }}" :active="request()->routeIs('admin.roles')">
                                    {{ __('Roles') }}
                                </x-navigation.nav-link>
                            </li>
                        </ul>
                    </li>
                    <li class="-mx-6 mt-auto">
                        <a href="{{ route('profile.show') }}"
                            class="flex items-center gap-x-4 px-6 py-3 text-sm font-semibold leading-6 text-blue-700 hover:bg-gray-50">
                            <x-wui-avatar xs />
                            <span class="sr-only">Your profile</span>
                            <span aria-hidden="true">{{ Auth::user()->name }}</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <div class="sticky top-0 z-40 flex items-center gap-x-6 bg-white px-4 py-4 shadow-sm sm:px-6 lg:hidden">
        <button @@click="openSideBar = true" type="button"
            class="-m-2.5 p-2.5 text-gray-700 lg:hidden">
            <span class="sr-only">Open sidebar</span>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>
        <div class="flex-1 text-sm font-semibold leading-6 text-gray-900">Dashboard</div>
        <a href="{{ route('profile.show') }}">
            <span class="sr-only">Your profile</span>
            <x-wui-avatar xs />
        </a>
    </div>
</div>
