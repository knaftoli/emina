<x-wui-card title="Add New Role">
    <form wire:submit.prevent="store" id="create-form">
        <div class="space-y-4 px-3">
            <div>
                <x-wui-input wire:model.lazy='role' label="Name" placeholder="Name"/>
            </div>
            <div>
                <fieldset>
                    <legend class="sr-only">Permissions</legend>
                    @foreach ($permissions as $permission)
                        <div class="space-y-4">
                            <div class="relative flex items-start">
                                <div class="flex h-6 items-center">
                                    <input
                                        wire:model.defer='checkedPermissions'
                                        id="{{$permission->id}}"
                                        value="{{$permission->name}}"
                                        type="checkbox"
                                        class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-600"
                                    />
                                </div>
                                <div class="ml-3 text-sm leading-6">
                                    <label for="{{$permission->id}}" class="font-medium text-gray-700">{{$permission->name}}</label>
                                    <span id="comments-description" class="text-gray-500">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </fieldset>
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
