<?php

namespace App\Http\Livewire\Admin\Modal\UserRole;

use App\Models\InvitedEmail;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use LivewireUI\Modal\ModalComponent;
use Spatie\Permission\Models\Role;

class Edit extends ModalComponent
{
    use AuthorizesRequests;

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
        $this->authorize('edit admin settings');
        $this->user->syncRoles($this->checkedRoles);
        $this->emit('refreshDatatable');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.modal.user-role.edit');
    }
}
