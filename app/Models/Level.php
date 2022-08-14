<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Level
 * 
 * @property string $level
 * 
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Level extends Model
{
	protected $table = 'levels';
	protected $primaryKey = 'level';
	public $incrementing = false;
	public $timestamps = false;

	public function users()
	{
		return $this->hasMany(User::class, 'level');
	}
}
