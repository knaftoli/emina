<?php

namespace App\Http\Livewire\Admin\Modal\Role;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use LivewireUI\Modal\ModalComponent;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;

class Edit extends ModalComponent
{
    use AuthorizesRequests;

    public Role $editing;
    public $permissions;
    public $checkedPermissions = [];
    public $oldPermissions = [];
    public $checked = 'checked';

    function mount() {
        $this->editing->name = Str::of($this->editing->name)->ucfirst();
        $this->permissions = Permission::all()->sortBy('name');
        foreach ($this->editing->permissions as $key => $value) {
            $this->checkedPermissions[] = $value['name'];
        }
    }

    public function rules()
    {
        return [
            'editing.name' => [
                'required',
                'min:3',
                Rule::unique('roles', 'name')->ignore($this->editing),
            ]
        ];
    }

    function update() {
        $this->authorize('edit admin settings');
        $this->validate();
        $this->editing->name = Str::lower($this->editing->name);
        $this->editing->save();
        $this->editing->syncPermissions($this->checkedPermissions);
        $this->emit('refreshDatatable');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.modal.role.edit');
    }
}
