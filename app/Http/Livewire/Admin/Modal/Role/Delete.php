<?php

namespace App\Http\Livewire\Admin\Modal\Role;

use LivewireUI\Modal\ModalComponent;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class Delete extends ModalComponent
{
    public Role $role;

    function mount() {
        $this->role->name = Str::of($this->role->name)->ucfirst();
    }

    function destroy()
    {
        $this->role->delete();
        $this->emit('refreshDatatable');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.modal.role.delete');
    }
}
