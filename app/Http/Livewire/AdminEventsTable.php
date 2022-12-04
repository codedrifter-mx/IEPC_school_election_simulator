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
                ->format(
                    fn($value, $row, Column $column) => $row->status
                )
                ->sortable(
                    fn(Builder $query, string $direction) => $query->orderBy('status')
                )
                ->label(fn($row) => $row->status == 0 ? '<span class="badge badge-danger">Inactivo</span>' : ($row->status == 1 ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-warning">Finalizado</span>'))
                ->html(),
            Column::make('Event Key', 'event_key')
                ->hideIf(true),
            Column::make('Escuela', 'user.name')
                ->sortable()
                ->searchable(),
            Column::make('Evento', 'name')
                ->sortable()
                ->searchable(),
            Column::make('Registro nominal', 'event_key')
                ->label(fn($row) => '<button onclick="showNominal(`' . $row->event_key . '`)" class="btn btn-primary btn-sm">Registro nominal</button>')
                ->html(),
            Column::make('Resultados', 'event_key')
                ->label(fn($row) => '<button onclick="showResultsModal(`' . $row->event_key . '`)" class="btn btn-primary btn-sm">Resultados</button>')
                ->html(),

        ];
    }

    public function builder(): Builder
    {
        // select raw with             // Add a numeric status column, if the event is between start_at and end_at, is 1, if the event is before start_at, is 0, if the event is after end_at, is 2, if the event is null, is 3

        return Event::query()
            ->selectRaw('events.*, IF(events.start_at <= NOW() AND events.end_at >= NOW(), 1, IF(events.start_at > NOW(), 0, IF(events.end_at < NOW(), 2, 3))) as status')
            ->where('approved', '!=', 0)
            // with user table left join
            ->leftJoin('users', 'events.user_id', '=', 'users.user_id');
    }

    // compu
}
