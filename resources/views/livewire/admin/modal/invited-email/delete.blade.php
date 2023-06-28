<x-wui-card title="Delete Invited Email">
    Are you sure you want to delete <span class="font-bold">{{ $invitedEmail->name }}</span> from the list?

    <x-slot name="footer">
        <div class="flex justify-items-center justify-end space-x-4">
            <x-wui-button wire:click="$emit('closeModal')" label="Cancel" sm />
            <x-wui-button wire:click='destroy' label="Delete" negative sm icon="trash" />
        </div>
    </x-slot>
</x-wui-card>
