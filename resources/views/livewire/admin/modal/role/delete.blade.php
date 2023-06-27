<x-wui-card title="Delete Role">
    Are you sure you want to delete {{ $role->name }} from the list?

    <x-slot name="footer">
        <div class="flex justify-items-center justify-end space-x-4">
            <x-wui-button wire:click="$emit('closeModal')" label="Cancel" sm />
            <x-wui-button wire:click='destroy' label="Delete" negative sm icon="trash" />
        </div>
    </x-slot>
</x-wui-card>
