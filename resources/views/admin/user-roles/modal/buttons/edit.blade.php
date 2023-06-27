{{-- @can('edit admin settings') --}}
<x-wui-button.circle flat secondary wire:click="$emit('openModal', 'admin.modal.user-role.edit', {{ json_encode(['user' => $value]) }})" class="px-4">
    <x-wui-icon name="pencil" class="w-4 h-4" />
</x-wui-button.circle>
{{-- @endcan --}}
