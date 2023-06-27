<?php

namespace App\Http\Livewire\Admin\Modal\Permission;

use LivewireUI\Modal\ModalComponent;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class Delete extends ModalComponent
{
    public Permission $permission;

    function mount() {
        $this->permission->name = Str::of($this->permission->name)->ucfirst();
    }

    function destroy() {
        $this->emit('refreshDatatable');
        $this->closeModal();
        $this->permission->delete();
    }

    public function render()
    {
        return view('livewire.admin.modal.permission.delete');
    }
}
