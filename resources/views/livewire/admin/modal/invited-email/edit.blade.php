<x-wui-card title="Edit New Invited Email">
    <form wire:submit.prevent="update" id="edit-form">
        <div class="space-y-4 px-3">
            <div>
                <x-wui-input wire:model.defer='editing.name' label="Full Name" placeholder="Full Name"/>
            </div>
            <div>
                <x-wui-input wire:model.defer='editing.email' label="Email" placeholder="Email"/>
            </div>
            <div>
                <x-wui-select
                    wire:model.defer='editing.role'
                    label="Role"
                    placeholder="Select a role"
                    :options="$options"
                    option-label="label"
                    option-value="value"
                />
            </div>
            <x-slot name="footer">
                <div class="flex justify-items-center justify-end space-x-4">
                    <x-wui-button wire:click="$emit('closeModal')" label="Cancel" sm />
                    <x-wui-button type="submit" form="edit-form" label="Save" primary sm right-icon="plus"/>
                </div>
            </x-slot>
        </div>
    </form>
</x-wui-card>
