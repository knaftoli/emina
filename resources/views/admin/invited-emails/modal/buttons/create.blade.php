@can('edit admin settings')
    <x-wui-button wire:click="$emit('openModal', 'admin.modal.invited-email.create')" label="Add New" primary right-icon="plus-sm" />
@endcan
