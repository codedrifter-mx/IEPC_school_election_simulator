<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Schedule
 * 
 * @property string $schedule
 * 
 * @property Collection|Event[] $events
 *
 * @package App\Models
 */
class Schedule extends Model
{
	protected $table = 'schedules';
	protected $primaryKey = 'schedule';
	public $incrementing = false;
	public $timestamps = false;

	public function events()
	{
		return $this->hasMany(Event::class, 'schedule');
	}
}
