<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Candidate
 * 
 * @property int $candidate_id
 * @property string $candidate_key
 * @property int $event_id
 * @property string $teamname
 * @property string $name
 * @property string $paternal_surname
 * @property string $maternal_surname
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Event $event
 * @property Collection|Vote[] $votes
 *
 * @package App\Models
 */
class Candidate extends Model
{
	protected $table = 'candidates';
	protected $primaryKey = 'candidate_id';

	protected $casts = [
		'event_id' => 'int'
	];

	protected $fillable = [
		'candidate_key',
		'event_id',
		'teamname',
		'name',
		'paternal_surname',
		'maternal_surname'
	];

	public function event()
	{
		return $this->belongsTo(Event::class);
	}

	public function votes()
	{
		return $this->hasMany(Vote::class);
	}
}
