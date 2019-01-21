<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Views extends Model
{
    public $table = "post_view_log";
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['post_id', 'address'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }

    public function check(){
        
    }

}
