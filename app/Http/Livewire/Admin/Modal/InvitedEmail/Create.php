<?php

namespace App\Http\Livewire\Admin\Modal\InvitedEmail;

use App\Models\InvitedEmail;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use LivewireUI\Modal\ModalComponent;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class Create extends ModalComponent
{
    use AuthorizesRequests;

    public InvitedEmail $invitedEmail;
    public $options = [];

    public function mount()
    {
        $this->invitedEmail = InvitedEmail::make();
        foreach(Role::all() as $role){
            $this->options[] = [
                'value' => $role->name,
                'label' => Str::of($role->name)->ucfirst()
            ];
        }
    }

    protected function rules()
    {
        return [
            'invitedEmail.name' => 'required|min:3',
            'invitedEmail.email' => 'required|email|unique:users,email',
            'invitedEmail.role' => 'required|exists:roles,name',
        ];
    }

    function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    public function store()
    {
        $this->authorize('edit admin settings');
        $this->validate();
        $this->invitedEmail->save();
        $this->emit('refreshDatatable');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.modal.invited-email.create');
    }
}
