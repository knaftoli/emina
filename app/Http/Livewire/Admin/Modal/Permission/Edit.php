<?php

namespace App\Http\Livewire\Admin\Modal\Permission;

use LivewireUI\Modal\ModalComponent;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class Edit extends ModalComponent
{
    public Permission $editing;
    public $roles;
    public $checkedRoles = [];

    function mount() {
        $this->editing->name = Str::of($this->editing->name)->ucfirst();
        $this->roles = Role::all()->sortBy('name');
        foreach ($this->editing->roles as $key => $value) {
            $this->checkedRoles[] = $value['name'];
        }
    }

    public function rules()
    {
        return [
            'editing.name' => [
                'required',
                'min:3',
                Rule::unique('permissions', 'name')->ignore($this->editing),
            ],
        ];
    }

    function update() {
        $this->validate();
        $this->editing->name = Str::lower($this->editing->name);
        $this->editing->save();
        $this->editing->syncRoles($this->checkedRoles);
        $this->emit('refreshDatatable');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.modal.permission.edit');
    }
}
