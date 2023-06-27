<?php

namespace App\Http\Livewire\Admin\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class PermissionTable extends DataTableComponent
{
    protected $model = Permission::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setAdditionalSelects(['permissions.id as id']);
        $this->setColumnSelectStatus(false);

        $this->setConfigurableAreas([
            'toolbar-left-start' => 'admin.permissions.modal.buttons.create',
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
                ->sortable()
                ->searchable(),
            Column::make('')
                ->label(
                    fn($row, Column $column) => view('admin.permissions.modal.buttons.edit-delete')->withValue($row->id)
                )
                ->html(),
            Column::make('Roles')
                ->label(
                    function($row, Column $column){
                        $permission = Permission::find($row->id);
                        return $permission->roles->pluck('name')->implode(' | ');
                    }
                ),
        ];
    }
}
