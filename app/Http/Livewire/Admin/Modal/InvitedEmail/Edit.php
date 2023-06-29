<?php

namespace App\Http\Livewire\Admin\Modal\InvitedEmail;

use App\Models\InvitedEmail;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use LivewireUI\Modal\ModalComponent;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class Edit extends ModalComponent
{
    use AuthorizesRequests;

    public InvitedEmail $editing;
    public $options = [];

    protected function rules()
    {
        return [
            'editing.name' => 'required|min:3',
            'editing.email' => 'required|email|unique:users,email',
            'editing.role' => 'required|exists:roles,name',
        ];
    }

    function mount() {
        foreach(Role::all() as $role){
            $this->options[] = [
                'value' => $role->name,
                'label' => Str::of($role->name)->ucfirst()
            ];
        }
    }

    function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    public function update()
    {
        $this->authorize('edit admin settings');
        $this->validate();
        $this->editing->save();
        $this->emit('refreshDatatable');
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.modal.invited-email.edit');
    }
}
