<?php

namespace App\Http\Livewire\Admin\Modal\InvitedEmail;

use App\Models\InvitedEmail;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use LivewireUI\Modal\ModalComponent;

class Delete extends ModalComponent
{
    use AuthorizesRequests;

    public InvitedEmail $invitedEmail;

    function destroy()
    {
        $this->authorize('edit admin settings');
        $this->invitedEmail->delete();
        $this->emit('refreshDatatable');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.modal.invited-email.delete');
    }
}
