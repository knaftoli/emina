<?php

namespace App\Http\Livewire\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\PropertyListing;

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

        $this->setTdAttributes(function(Column $column, $row, $columnIndex, $rowIndex) {
              return [
                'default' => false,
                'class' => 'px-6 py-4 text-sm font-medium dark:text-white',
              ];
          });
    }

    public function columns(): array
    {
        return [
            Column::make("Address", 'address')
                ->searchable()
                ->format(
                    fn($value, $row, Column $column)  => '<a href="' . $row->uri . '" target="_blank" class="text-blue-600">' . $row->address . '</a>'
                )
                ->html(),
            Column::make("Agent", "agent")
                ->sortable()
                ->searchable(),
            Column::make("Price", "price")
                ->sortable()
                ->searchable(),
            Column::make('Search', 'search_term')
                    ->sortable(),
            Column::make("Added", "created_at")
                ->sortable()
                ->format(
                    fn($value, $row, Column $column) => $row->created_at->diffForHumans()
                ),
        ];
    }
}
