<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 *
 * @property int $user_id
 * @property string $name
 * @property string|null $charge
 * @property string|null $municipality
 * @property string|null $address
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $level
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Event[] $events
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
	protected $primaryKey = 'user_id';

	protected $dates = [
		'email_verified_at'
	];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'charge',
        'municipality',
        'address',
        'email',
        'email_verified_at',
        'level',
        'password',
        'remember_token'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */

	protected $hidden = [
		'password',
		'remember_token'
	];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

	public function level()
	{
		return $this->belongsTo(Level::class, 'level');
	}

	public function events()
	{
		return $this->hasMany(Event::class);
	}
}
