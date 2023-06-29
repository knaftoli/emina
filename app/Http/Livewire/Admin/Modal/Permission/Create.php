<?php

namespace App\Http\Livewire\Admin\Modal\Permission;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use LivewireUI\Modal\ModalComponent;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class Create extends ModalComponent
{
    use AuthorizesRequests;

    public String $permission;
    public $roles;
    public $checkedRoles = [];

    protected $rules = [
        'permission' => 'required|min:3|unique:permissions,name'
    ];

    function mount() {
        $this->roles = Role::all()->sortBy('name');
    }

    function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    function store() {
        $this->authorize('edit admin settings');
        $this->validate();
        $newPermission = Permission::create(['guard_name' => 'web', 'name' => Str::lower($this->permission)]);
        $newPermission->syncRoles($this->checkedRoles);
        $this->emit('refreshDatatable');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.modal.permission.create');
    }
}
