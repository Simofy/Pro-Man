<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Events\ {
    ModelCreated
};
class Project extends Model
{
    use IngoingTrait;

    protected $dispatchesEvents = [
        'created' => ModelCreated::class,
        'updated' => ModelCreated::class,
    ];

    protected $fillable = [
        'name', 'user_id',
    ];

}
