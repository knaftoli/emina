<x-wui-card title="Add New Invited Email">
    <form wire:submit.prevent="store" id="create-form">
        <div class="space-y-4 px-3">
            <div>
                <x-wui-input wire:model.lazy='invitedEmail.name' label="Full Name" placeholder="Full Name"/>
            </div>
            <div>
                <x-wui-input wire:model.lazy='invitedEmail.email' label="Email" placeholder="Email"/>
            </div>
            <div>
                <x-wui-select
                    wire:model='invitedEmail.role'
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
                    <x-wui-button type="submit" form="create-form" label="Add" primary sm right-icon="plus"/>
                </div>
            </x-slot>
        </div>
    </form>
</x-wui-card>
