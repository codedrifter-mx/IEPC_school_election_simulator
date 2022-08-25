<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Elector
 *
 * @property int $elector_id
 * @property int $event_id
 * @property string $name
 * @property string $paternal_surname
 * @property string $maternal_surname
 * @property string|null $email
 * @property string $code
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Event $event
 * @property Collection|Vote[] $votes
 *
 * @package App\Models
 */
class Elector extends Model
{
	protected $table = 'electors';
	protected $primaryKey = 'elector_id';

	protected $casts = [
		'event_id' => 'int'
	];

	protected $fillable = [
		'event_id',
		'name',
		'paternal_surname',
		'maternal_surname',
		'email',
		'code'
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
