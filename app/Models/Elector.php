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
 * @property string $elector_key
 * @property string $event_key
 * @property string $paternal_surname
 * @property string $maternal_surname
 * @property string $name
 * @property string $grade
 * @property string $group
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

	protected $fillable = [
		'elector_key',
		'event_key',
		'paternal_surname',
		'maternal_surname',
		'name',
		'grade',
		'group',
		'email',
		'code'
	];

	public function event()
	{
		return $this->belongsTo(Event::class, 'event_key', 'event_key');
	}

	public function votes()
	{
		return $this->hasMany(Vote::class);
	}
}
