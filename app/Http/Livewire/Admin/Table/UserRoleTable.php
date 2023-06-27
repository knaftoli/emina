<?php

namespace App\Http\Livewire\Admin\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Support\Str;
use App\Models\User;

class UserRoleTable extends DataTableComponent
{
    protected $model = User::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setAdditionalSelects(['users.id as id']);

        $this->setComponentWrapperAttributes([
            'class' => 'p-4',
          ]);

          $this->setTbodyAttributes([
            'default' => true,
            'class' => 'text-gray-600',
        ]);

        // Takes a callback that gives you the current row and its index
        $this->setTrAttributes(function($row, $index) {
            return [
                'class' => 'border-gray-200 hover:bg-gray-100'
            ];
        });
    }

    public function columns(): array
    {
        return [
            Column::make("Name", "name")
                ->sortable(),
            Column::make("Roles")
                ->label(
                    fn($row, Column $column) => $this->getRole($row->id)->implode(' | ')
                ),
            Column::make('')
                ->label(
                    fn($row, Column $column) => view('admin.user-roles.modal.buttons.edit')->withValue($row->id)
                )
                ->html(),
        ];
    }

    function getRole($id) {
        $user = User::find($id);
        $roles = $user->getRoleNames();
        return $roles->map(fn($item) => Str::of($item)->ucfirst);
    }
}
