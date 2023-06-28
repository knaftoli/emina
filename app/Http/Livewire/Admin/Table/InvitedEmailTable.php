<?php

namespace App\Http\Livewire\Admin\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\InvitedEmail;
use Illuminate\Support\Str;

class InvitedEmailTable extends DataTableComponent
{
    protected $model = InvitedEmail::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setAdditionalSelects(['invited_emails.id as id']);
        $this->setColumnSelectStatus(false);

        $this->setConfigurableAreas([
            'toolbar-left-start' => 'admin.invited-emails.modal.buttons.create',
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
                ->sortable()
                ->searchable()
                ->excludeFromColumnSelect(),
            Column::make("Email", "email")
                ->sortable()
                ->searchable(),
            Column::make("Role", "role")
                ->format(
                    fn($value, $row, Column $column) => Str::of($value)->ucfirst()
                )
                ->sortable()
                ->searchable(),
           Column::make('')
                ->label(
                    fn($row, Column $column) => view('admin.invited-emails.modal.buttons.edit-delete')->withValue($row->id)
                )
                ->html(),
        ];
    }
}
