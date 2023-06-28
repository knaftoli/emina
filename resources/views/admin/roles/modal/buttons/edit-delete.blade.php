@can('edit admin settings')
    <x-wui-button.circle flat secondary wire:click="$emit('openModal', 'admin.modal.role.edit', {{ json_encode(['editing' => $value]) }})" class="px-4">
            <x-wui-icon name="pencil" class="w-4 h-4" />
    </x-wui-button.circle>
    <x-wui-button.circle flat secondary wire:click="$emit('openModal', 'admin.modal.role.delete', {{ json_encode(['role' => $value]) }})" class="px-4">
            <x-wui-icon name="trash" class="w-4 h-4" />
    </x-wui-button.circle>
@endcan
