<?php

namespace App\Http\Livewire\Admin\Modal\Permission;

use LivewireUI\Modal\ModalComponent;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class Create extends ModalComponent
{
    public String $permission;

    protected $rules = [
        'permission' => 'required|min:3|unique:permissions,name'
    ];

    function store() {
        $this->validate();
        Permission::create(['guard_name' => 'web', 'name' => Str::lower($this->permission)]);
        $this->emit('refreshDatatable');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.modal.permission.create');
    }
}
