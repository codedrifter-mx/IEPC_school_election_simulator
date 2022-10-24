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
 * @property string $cycle
 * @property int $population
 * @property int $groups
 * @property string $schedule
 * @property string $director
 * @property string $responsible
 * @property string $responsible_phone
 * @property Carbon $start_at
 * @property Carbon|null $end_at
 * @property bool $approved
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 * @property Collection|Candidate[] $candidates
 * @property Collection|Elector[] $electors
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
		'groups' => 'int',
		'approved' => 'bool'
	];

	protected $dates = [
		'start_at',
		'end_at'
	];

	protected $fillable = [
		'event_key',
		'user_id',
		'name',
		'cycle',
		'population',
		'groups',
		'schedule',
		'director',
		'responsible',
		'responsible_phone',
		'start_at',
		'end_at',
		'approved'
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

	public function electors()
	{
		return $this->hasMany(Elector::class, 'event_key', 'event_key');
	}

	public function votes()
	{
		return $this->hasMany(Vote::class);
	}
}
