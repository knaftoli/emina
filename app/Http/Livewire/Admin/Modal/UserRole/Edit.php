<?php

namespace App\Http\Livewire\Admin\Modal\UserRole;

use App\Models\InvitedEmail;
use App\Models\User;
use LivewireUI\Modal\ModalComponent;
use Spatie\Permission\Models\Role;

class Edit extends ModalComponent
{
    public $roles;
    public $checkedRoles = [];
    public User $user;
    public $invitedEmail;

    function mount() {
        $this->roles = Role::all();
        foreach($this->roles as $role){
            if($this->user->hasRole($role)){
                $this->checkedRoles[] = $role->name;
            }
        }
        $this->invitedEmail = InvitedEmail::where('email', 'knaftoli@gmail.com')->first();
    }

    function update() {
        $this->user->syncRoles($this->checkedRoles);
        $this->emit('refreshDatatable');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.modal.user-role.edit');
    }
}
