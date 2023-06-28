<x-wui-card title="Delete User">
    Are you sure you want to completley delete the user <span class="font-bold">{{ $user->name }}</span> from this website?

    <x-slot name="footer">
        <div class="flex justify-items-center justify-end space-x-4">
            <x-wui-button wire:click="$emit('closeModal')" label="Cancel" sm />
            <x-wui-button wire:click='destroy' label="Delete" negative sm icon="trash" />
        </div>
    </x-slot>
</x-wui-card>
