<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Project;
use Storage;
use App\Events\ {
    ModelCreated
};

class File extends Model
{
    public $table = "files";
    use IngoingTrait;

    protected $dispatchesEvents = [
        'created' => ModelCreated::class,
        'updated' => ModelCreated::class,
    ];
    protected $fillable = [
        'path', 'project_id'
    ];
    // public function createFile($project, $name, $data){
    //     $file_path_name = 'projects/' . $project . '/' . $name;
    //     Storage::put($file_path_name, $data);
    //     $projectId = $this->model->select('id')->where([['user_id', $user],['name', $project]])->get();
    // }
    // /**
    //  * One to Many relation
    //  *
    //  * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    //  */
    // public function project()
    // {
    //     return $this->belongsTo(Project::class);
    // }


}
