<?php

namespace App\Http\Livewire\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\PropertyListing;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class PropertyListingTable extends DataTableComponent
{
    protected $model = PropertyListing::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setAdditionalSelects(['property_listings.id as id']);
        $this->setAdditionalSelects(['property_listings.right_move_id as right_move_id']);
        $this->setAdditionalSelects(['property_listings.uri as uri']);
        $this->setColumnSelectStatus(false);

        $this->setConfigurableAreas([
            'toolbar-left-start' => 'property-listings/buttons/scrape',
        ]);

        $this->setComponentWrapperAttributes([
            'class' => 'p-4',
          ]);

          $this->setTableAttributes([
            'default' => true,
            'class' => 'table-auto',
          ]);

        $this->setTbodyAttributes([
            'default' => true,
            'class' => 'text-gray-600',
        ]);

        $this->setDefaultSort('created_at', 'desc');

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
            Column::make("Address", "address")
                ->sortable()
                ->searchable(),
            Column::make("Agent", "agent")
                ->sortable()
                ->searchable(),
            Column::make("Price", "price")
                ->sortable()
                ->searchable(),
            Column::make('link')
                ->label(
                    fn($row, Column $column)  => '<a href="' . $row->uri . '" target="_blank" class="text-blue-600">Link</a>'
                )
                ->html(),
            Column::make("Added", "created_at")
                ->sortable()
                ->format(
                    fn($value, $row, Column $column) => $row->created_at->diffForHumans()
                ),
        ];
    }
}
