<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Candidate;

class CandidatesTable extends DataTableComponent
{
    protected $model = Candidate::class;

    public function configure(): void
    {
        $this->setPrimaryKey('candidate_id')
            ->setRefreshKeepAlive()
            ->setColumnSelectStatus(false)
            ->setPaginationDisabled()
            ->setSearchDisabled()
            ->setPaginationVisibilityDisabled();
    }

    public function columns(): array
    {
        return [
            Column::make("Candidate id", "candidate_id")
                ->sortable()
                ->hideIf(true),
            Column::make("Candidate key", "candidate_key")
                ->sortable()
                ->hideIf(true),

            Column::make("Event id", "event_id")
                ->sortable()
                ->hideIf(true),
            Column::make("Planilla", "teamname")
                ->sortable(),
            Column::make("Nombre Completo", "name")
                ->sortable(),
            Column::make('Editar', 'candidate_id')
                ->label(fn($row) => '<button onclick="setCandidate(`' . $row->candidate_id . '`)" class="btn btn-primary btn-sm">Editar</button>')
                ->html(),
            // add a 'Borrar' button column
            Column::make('Borrar', 'candidate_id')
                ->label(fn($row) => '<button onclick="dropCandidate(`' . $row->candidate_id . '`)" class="btn btn-danger btn-sm">Borrar</button>')
                ->html(),
        ];
    }
}
