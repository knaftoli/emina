<x-wui-card title="Add New Permission">
    <form wire:submit.prevent="store" id="create-form">
        <div class="space-y-4 px-3">
            <div>
                <x-wui-input wire:model.defer='permission' label="Name" placeholder="Name"/>
            </div>
            <x-slot name="footer">
                <div class="flex justify-items-center justify-end space-x-4">
                    <x-wui-button wire:click="$emit('closeModal')" label="Cancel" sm />
                    <x-wui-button type="submit" form="create-form" label="Add" primary sm right-icon="plus"/>
                </div>
            </x-slot>
        </div>
    </form>
</x-wui-card>
