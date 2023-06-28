<?php

namespace App\Http\Livewire\Admin\Modal\UserRole;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use LivewireUI\Modal\ModalComponent;

class Delete extends ModalComponent
{
    use AuthorizesRequests;

    public User $user;

    function destroy() {
        $this->authorize('edit admin settings');
        $this->user->tokens->each->delete();
        $this->user->delete();
        $this->emit('refreshDatatable');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.modal.user-role.delete');
    }
}
