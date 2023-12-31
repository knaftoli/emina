<?php

namespace App\Http\Livewire\Admin\Modal\Role;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use LivewireUI\Modal\ModalComponent;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class Delete extends ModalComponent
{
    use AuthorizesRequests;

    public Role $role;

    function mount() {
        $this->role->name = Str::of($this->role->name)->ucfirst();
    }

    function destroy()
    {
        $this->authorize('edit admin settings');
        $this->role->delete();
        $this->emit('refreshDatatable');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.modal.role.delete');
    }
}
