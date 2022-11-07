<?php

namespace App\Http\Livewire;

use App\Models\Event;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class AdminEventsTable extends DataTableComponent
{
    public string $tableName = 'events';

    public function configure(): void
    {
        $this->setPrimaryKey('event_key')
            ->setRefreshKeepAlive();
    }

    public function columns(): array
    {
        return [
            Column::make('Estado', 'status')
                ->sortable()
                ->label(fn($row) => $row->status == 0 ? '<span class="badge badge-danger">Inactivo</span>' : ($row->status == 1 ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-warning">Finalizado</span>'))
                ->html(),
            // add event_key column, but hide it
            Column::make('Event Key', 'event_key')
                ->hideIf(true),
            // name column as 'Evento' for events, with filter, sort and search
            Column::make('Evento', 'name')
                ->sortable()
                ->searchable(),
            // start_at column as 'Fecha de inicio' for events, with filter, sort and search
            Column::make('Fecha de inicio', 'start_at')
                ->sortable(),
            // end_at column as 'Fecha de fin' for events, with filter, sort and search
            Column::make('Fecha de fin', 'end_at')
                ->sortable()
                // if end_at empty, show badge "IEPC por confirmar"
                ->label(fn($row) => $row->end_at == null ? '<span class="badge badge-warning">IEPC por confirmar</span>' : $row->end_at)
                ->html(),
        ];
    }

    public function builder(): Builder
    {
        // select raw with             // Add a numeric status column, if the event is between start_at and end_at, is 1, if the event is before start_at, is 0, if the event is after end_at, is 2, if the event is null, is 3

        return Event::query()
            ->selectRaw('events.*, IF(events.start_at <= NOW() AND events.end_at >= NOW(), 1, IF(events.start_at > NOW(), 0, IF(events.end_at < NOW(), 2, 3))) as status')
            ->where('end_at', '>=', now());
    }

    // compu
}
