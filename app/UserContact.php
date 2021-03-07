<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Relations\Relation;

// Relation::morphMap([
//     UserContact::class,
// ]);

class UserContact extends Model
{
    use SoftDeletes;

    protected $fillable = [
		 'user_id', 'name', 'phone', 'email'
	];

    public function ownable()
    {
    	return $this->morphTo();
    }

    public function UserContact(){
        return $this->belongsTo(UserContact::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
