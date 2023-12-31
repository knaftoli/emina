<?php

namespace App\Http\Livewire\Admin\Modal\Permission;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use LivewireUI\Modal\ModalComponent;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class Delete extends ModalComponent
{
    use AuthorizesRequests;

    public Permission $permission;

    function mount() {
        $this->permission->name = Str::of($this->permission->name)->ucfirst();
    }

    function destroy() {
        $this->authorize('edit admin settings');
        $this->permission->delete();
        $this->emit('refreshDatatable');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.modal.permission.delete');
    }
}
