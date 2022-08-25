<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Vote
 *
 * @property int $vote_id
 * @property int $elector_id
 * @property int $candidate_id
 * @property int $event_id
 *
 * @property Candidate $candidate
 * @property Event $event
 * @property Elector $elector
 *
 * @package App\Models
 */
class Vote extends Model
{
	protected $table = 'votes';
	protected $primaryKey = 'vote_id';
	public $timestamps = false;

	protected $casts = [
		'elector_id' => 'int',
		'candidate_id' => 'int',
		'event_id' => 'int'
	];

	protected $fillable = [
		'elector_id',
		'candidate_id',
		'event_id'
	];

	public function candidate()
	{
		return $this->belongsTo(Candidate::class);
	}

	public function event()
	{
		return $this->belongsTo(Event::class);
	}

	public function voter()
	{
		return $this->belongsTo(Elector::class);
	}
}
