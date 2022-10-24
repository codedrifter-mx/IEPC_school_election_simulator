<?php

namespace App\Http\Livewire;

use App\Models\Event;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class EventsTable extends DataTableComponent
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
                ->sortable(),
            Column::make('Editar', 'event_key')
                ->label(fn($row) => '<button onclick="setEvent(`' . $row->event_key . '`)" class="btn btn-primary btn-sm">Editar</button>')
                ->html(),
            // add a 'Borrar' button column
            Column::make('Borrar', 'event_key')
                ->label(fn($row) => '<button onclick="dropEvent(`' . $row->event_key . '`)" class="btn btn-danger btn-sm">Borrar</button>')
                ->html(),
        ];
    }

    public function builder(): Builder
    {

        return Event::query()
            ->where('user_id', Auth::user()->user_id)
            // Add a numeric status column, if the event is between start_at and end_at, is 1, if the event is before start_at, is 0, if the event is after end_at, is 2
            ->addSelect([
                'status' => Event::query()
                    ->selectRaw('CASE WHEN ? BETWEEN start_at AND end_at THEN 1 WHEN ? < start_at THEN 0 ELSE 2 END', [now(), now()])
                    ->limit(1)
            ]);

    }
}
