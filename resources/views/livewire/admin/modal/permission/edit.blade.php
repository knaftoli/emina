<x-wui-card title="Edit Permission {{ $editing->name }}">
    <form wire:submit.prevent="update" id="edit-form">
        <div class="space-y-4 px-3">
            <div>
                <x-wui-input wire:model.lazy='editing.name' label="Name" placeholder="Name"/>
            </div>
            <div>
                <fieldset>
                    <legend class="text-base leading-6 text-gray-700">Permissions</legend>
                    @foreach ($roles as $role)
                        <div class="space-y-4">
                            <div class="relative flex items-start">
                                <div class="flex h-6 items-center">
                                    <input
                                        wire:model.defer='checkedRoles'
                                        id="{{$role->id}}"
                                        value="{{$role->name}}"
                                        type="checkbox"
                                        class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-600"
                                    />
                                </div>
                                <div class="ml-3 text-sm leading-6">
                                    <label for="{{$role->id}}" class="font-medium text-gray-700">{{Str::of($role->name)->ucfirst()}}</label>
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
                    <x-wui-button type="submit" form="edit-form" label="Save" primary sm/>
                </div>
            </x-slot>
        </div>
    </form>
</x-wui-card>
