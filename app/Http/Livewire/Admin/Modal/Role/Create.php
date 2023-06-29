<?php

namespace App\Http\Livewire\Admin\Modal\Role;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use LivewireUI\Modal\ModalComponent;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class Create extends ModalComponent
{
    use AuthorizesRequests;

    public String $role;
    public $permissions;
    public $checkedPermissions = [];

    protected $rules = [
        'role' => 'required|min:3|unique:roles,name'
    ];

    function mount() {
        $this->permissions = Permission::all();
    }

    function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    function store() {
        $this->authorize('edit admin settings');
        $this->validate();
        $role = Role::create(['guard_name' => 'web', 'name' => Str::lower($this->role)]);
        $role->syncPermissions($this->checkedPermissions);
        $this->emit('refreshDatatable');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.modal.role.create');
    }
}
