<?php

namespace App\Http\Livewire;

use App\Models\Event;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;

class AdminEventsTable extends DataTableComponent
{
    public string $tableName = 'events';

    public function configure(): void
    {
        $this->setPrimaryKey('event_key')
            ->setRefreshKeepAlive()
            ->setColumnSelectStatus(false)
            ->setPaginationDisabled()
            ->setSearchDisabled()
            ->setPaginationVisibilityDisabled();
    }

    // translate all the english words to spanish
    public function messages(): array
    {
        return [
            'search' => 'Buscar',
            'filters' => 'Filtros',
            'all' => 'Todos',
            'clear' => 'Limpiar',
            'no_results' => 'No se encontraron resultados',
            'no_rows' => 'No hay registros',
            'showing_rows' => 'Mostrando :from a :to de :total registros',
            'showing_rows_to' => 'Mostrando :from a :to de :total registros',
            'showing_rows_of' => 'Mostrando :from a :to de :total registros',
            'export' => 'Exportar',
            'export_all' => 'Exportar todo',
            'export_filtered' => 'Exportar filtrado',
            'column_visibility' => 'Visibilidad de columnas',
            'apply' => 'Aplicar',
            'cancel' => 'Cancelar',
            'columns' => 'Columnas',
            'column' => 'Columna',
            'direction' => 'Dirección',
            'asc' => 'Ascendente',
            'desc' => 'Descendente',
            'sort' => 'Ordenar',
            'sort_ascending' => 'Ordenar ascendente',
            'sort_descending' => 'Ordenar descendente',
            'loading' => 'Cargando',
            'loading_more' => 'Cargando más',
            'loading_filtered' => 'Cargando filtrado',
            'loading_filtered_more' => 'Cargando filtrado más',
            'filter' => 'Filtrar',
            'filter_by' => 'Filtrar por',
            'filters_applied' => 'Filtros aplicados',
            'filters_applied_clear' => 'Limpiar filtros',
            'filters_clear' => 'Limpiar filtros',
            'first_page' => 'Primera página',
            'last_page' => 'Última página',
            'next_page' => 'Página siguiente',
            'previous_page' => 'Página anterior',
            'refresh' => 'Refrescar',
            'refreshing' => 'Refrescando',
            'refreshing_info' => 'Refrescando información',
            'reset' => 'Reiniciar',
            'resetting' => 'Reiniciando',
            'resetting_info' => 'Reiniciando información',
            'select' => 'Seleccionar',
            'select_all' => 'Seleccionar todo',
            'select_none' => 'Seleccionar nada',
            'select_placeholder' => 'Seleccionar',
            'select_placeholder_multiple' => 'Seleccionar uno o más',
            'select_placeholder_none' => 'Nada seleccionado',
            'select_all_none' => 'Seleccionar todo / nada',
            'select_rows' => 'Seleccionar :rows',
            'select_rows_none' => 'Nada seleccionado',
            'select_rows_all' => 'Seleccionar todo',
            'select_rows_inverse' => 'Seleccionar inverso',
            'select_page' => 'Seleccionar página',
            'select_page_none' => 'Nada seleccionado',
            'select_page_all' => 'Seleccionar todo',
            'select_page_inverse' => 'Seleccionar inverso',
            'deselect_page' => 'Deseleccionar página',
            'select_all_pages' => 'Seleccionar todas las páginas',
            'select_all_pages_none' => 'Nada seleccionado',
            'select_all_pages_all' => 'Seleccionar todo',
            'select_all_pages_inverse' => 'Seleccionar inverso',
            'deselect_all_pages' => 'Deseleccionar todas las páginas',
            'select_inverse' => 'Seleccionar inverso',
            'deselect' => 'Deseleccionar',
            'deselect_all' => 'Deseleccionar todo',
            'deselect_inverse' => 'Deseleccionar inverso'
        ];
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
//            Column::make('Resultados', 'event_key')
//                ->label(fn($row) => '<button onclick="showResultsModal(`' . $row->event_key . '`)" class="btn btn-primary btn-sm">Resultados</button>')
//                ->html() only show this if status is 2
        Column::make('Resultados', 'event_key')
                ->label(fn($row) => $row->status == 2 ? '<button onclick="showResultsModal(`' . $row->event_key . '`)" class="btn btn-primary btn-sm">Ver Archivos</button>' : '')
                ->html(),
        ];
    }

    public function builder(): Builder
    {
        return Event::query()
            ->selectRaw('events.*, IF(events.start_at <= CONVERT_TZ(NOW(),"SYSTEM","America/Mexico_City") AND events.end_at >= CONVERT_TZ(NOW(),"SYSTEM","America/Mexico_City"), 1, IF(events.start_at > CONVERT_TZ(NOW(),"SYSTEM","America/Mexico_City"), 0, IF(events.end_at < CONVERT_TZ(NOW(),"SYSTEM","America/Mexico_City"), 2, 3))) as status')
            ->where('approved', '!=', 0)
            // with user table left join
            ->leftJoin('users', 'events.user_id', '=', 'users.user_id');
    }
}
