<div class="border-b border-blue-200 pb-2">
    <div class="flex justify-between">
        <div>
            <h3 class="text-base font-semibold leading-6 text-blue-700">{{ $slot }}</h3>
        </div>
        <div>
            <form method="POST" action="{{ route('logout') }}" x-data>
                @csrf
                <x-wui-button @@click.prevent="$root.submit();" rounded label="Logout" xs info/>
            </form>
        </div>
    </div>
</div>
