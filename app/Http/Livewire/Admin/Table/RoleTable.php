<?php

namespace App\Http\Livewire\Admin\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class RoleTable extends DataTableComponent
{
    protected $model = Role::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setAdditionalSelects(['roles.id as id']);
        $this->setSearchStatus(false);
        $this->setColumnSelectStatus(false);
        $this->setPerPageVisibilityDisabled();

        $this->setConfigurableAreas([
            'toolbar-left-start' => 'admin.roles.modal.buttons.create',
        ]);

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
                ->format(
                    fn($value, $row, Column $column) => Str::of($value)->ucfirst()
                )
                ->sortable(),
            Column::make('')
                ->label(
                    fn($row, Column $column) => view('admin.roles.modal.buttons.edit-delete')->withValue($row->id)
                )
                ->html(),
            Column::make('Permissions')
                ->label(
                    function($row, Column $column){
                        $role = Role::find($row->id);
                        return $role->permissions->pluck('name')->implode(' | ');
                    }
                ),
        ];
    }
}
