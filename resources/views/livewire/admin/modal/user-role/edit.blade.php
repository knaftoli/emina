<x-wui-card title="Edit User Roles">
    <form wire:submit.prevent="update" id="edit-form">
        <div class="space-y-4 px-3">
            <div>
                <fieldset>
                    <legend class="sr-only">Roles</legend>
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
                                        @checked(in_array($role->name, $checkedRoles))
                                    />
                                </div>
                                <div class="ml-3 text-sm leading-6">
                                    <label for="{{$role->id}}" class="font-medium text-gray-700">{{ Str::of($role->name)->ucfirst()}}</label>
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
