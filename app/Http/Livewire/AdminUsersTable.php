<?php

namespace App\Http\Livewire;

use App\Models\User;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class AdminUsersTable extends DataTableComponent
{
    public string $tableName = 'users';

    public function configure(): void
    {
        $this->setPrimaryKey('user_id')
            ->setRefreshKeepAlive();
    }

    public function columns(): array
    {
        return [
            // name column
            Column::make('Nombre', 'name')
                ->sortable()
                ->searchable(),
            // charge
            Column::make('Cargo', 'charge')
                ->sortable()
                ->searchable(),
            // email column
            Column::make('Email')
                ->sortable()
                ->searchable(),
            // created_at column
            Column::make('Creado en:', 'created_at')
                ->sortable()
                ->searchable(),
            Column::make('Aceptar', 'user_id')
                ->label(fn($row) => '<button onclick="accept(`' . $row->user_id . '`)" class="btn btn-primary btn-sm">Aceptar</button>')
                ->html(),
            //deny
            Column::make('Denegar', 'user_id')
                ->label(fn($row) => '<button onclick="deny(`' . $row->user_id . '`)" class="btn btn-danger btn-sm">Denegar</button>')
                ->html(),
        ];
    }

    public function builder(): Builder
    {
        return User::query()
            ->selectRaw('users.*')
            ->where('users.email_verified_at', '=', null)
            ->where('users.level', '=', "Administrador");
    }
}
