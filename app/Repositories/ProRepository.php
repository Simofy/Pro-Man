<?php

namespace App\Repositories;

use App\Models\File;
use App\Models\Project;
use Storage;

class ProRepository
{

    /**
     * The Model instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;
    protected $file;

    public function __construct(Project $project, File $file)
    {
        $this->model = $project;
        $this->file = $file;
    }

    public function queryFiles($project, $user)
    {
        $projectId = $this->model->select('id')->where('user_id', $user)->where('name', $project)->get();
        return $this->file->select('id', 'path', 'created_at', 'updated_at')
            ->orderBy('path', 'desc')
            ->where('project_id', $projectId[0]->id)->get();
    }

    public function getProject($project, $user)
    {

        //reikia middleware auth

        return $this->queryFiles($project, $user);
    }
    public function newProject($projectName, $user)
    {
        $project = array('name' => $projectName, 'user_id' => $user);
        Project::create($project);
    }
    public function getProjects($user)
    {
        return $this->model->where('user_id', $user)->get();
    }

    public function getFile($project, $name, $user)
    {
        //REIKIA STIPRAUS CONTROLO
        //$file_path = [];
        $projectId = $this->model->select('id')->where('user_id', $user)->where('name', $project)->get();
        $file_path = $this->file->select('path')
            ->where([['path', $name], ['project_id', $projectId[0]->id]])->get();
        //error_log($name);

        if (empty(sizeof($file_path))) {
            //error_log("SUka");
            return "";
        } else {
            $file_path_name = 'projects/' . $project . '/' . $file_path[0]->path;
            if (Storage::disk('local')->exists($file_path_name)) {
                $file_ = Storage::get($file_path_name);
                return $file_;
            } else {
                return "";
            }

        }
        //reikia middleware auth
    }
    public function createFile($project, $projectId, $name, $data)
    {
        $file_path_name = 'projects/' . $project . '/' . $name;
        Storage::put($file_path_name, $data);
        //$projectId = $this->model->select('id')->where([['user_id', $user], ['name', $project]])->get();
        $file = array('path' => $name, 'project_id' => $projectId);
        File::create($file);
    }
    public function saveFile($project, $data, $id, $user, $name)
    {
        //REIKIA STIPRAUS CONTROLO
        //$file_path = [];
        $projectId = $this->model->select('id')->where([['user_id', $user], ['name', $project]])->get();
        $file_path = $this->file->select('path')
            ->where([['path', $name], ['project_id', $projectId[0]->id]])->get();
        if (empty(sizeof($file_path))) {

            $this->createFile($project, $projectId[0]->id, $name, $data);
            return "";
        } else {
            $file_path_name = 'projects/' . $project . '/' . $file_path[0]->path;
            Storage::put($file_path_name, $data);

        }
        //reikia middleware auth
    }
    public function renameFile($project, $data, $id, $user, $name)
    {
        $projectId = $this->model->select('id')->where([['user_id', $user], ['name', $project]])->get();
        $file_path = $this->file->select('path')
            ->where([['path', $name], ['project_id', $projectId[0]->id]])->get();
        if (empty(sizeof($file_path))) {
            return "";
        } else {
            $file_path_name = 'projects/' . $project . '/' . $file_path[0]->path;
            $file_path_name_new = 'projects/' . $project . '/' . $data;
            File::where('id', $id)->update(array('path' => $data));
            if (!Storage::disk('local')->exists($file_path_name_new)) {
                Storage::move($file_path_name, $file_path_name_new);
            }

        }
    }
    public function deleteFile($project, $id, $user, $name)
    {
        $projectId = $this->model->select('id')->where([['user_id', $user], ['name', $project]])->get();
        $file_path = $this->file->select('path')
            ->where([['path', $name], ['project_id', $projectId[0]->id]])->get();
        if (empty(sizeof($file_path))) {
            return "";
        } else {
            File::where('id', $id)->delete();
        }
    }
}
