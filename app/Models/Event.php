<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Event
 * 
 * @property int $event_id
 * @property string $event_key
 * @property int $user_id
 * @property string $name
 * @property string $schedule
 * @property string $director
 * @property string $in_charge
 * @property int $population
 * @property int $groups
 * @property Carbon|null $start_at
 * @property Carbon|null $end_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 * @property Collection|Candidate[] $candidates
 * @property Collection|Vote[] $votes
 *
 * @package App\Models
 */
class Event extends Model
{
	protected $table = 'events';
	protected $primaryKey = 'event_id';

	protected $casts = [
		'user_id' => 'int',
		'population' => 'int',
		'groups' => 'int'
	];

	protected $dates = [
		'start_at',
		'end_at'
	];

	protected $fillable = [
		'event_key',
		'user_id',
		'name',
		'schedule',
		'director',
		'in_charge',
		'population',
		'groups',
		'start_at',
		'end_at'
	];

	public function schedule()
	{
		return $this->belongsTo(Schedule::class, 'schedule');
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function candidates()
	{
		return $this->hasMany(Candidate::class);
	}

	public function votes()
	{
		return $this->hasMany(Vote::class);
	}
}
