<?php

namespace App\Http\Controllers\Pro;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Project;
use App\Repositories\ProRepository;
use Auth;
use Illuminate\Http\Request;

class ProController extends Controller
{
    protected $proRepository;
    public function __construct(ProRepository $proRepository)
    {
        $this->proRepository = $proRepository;
        //$this->nbrPages = config('app.nbrPages.front.posts');
    }

    public function index()
    {

        //Storage::disk('local')->put('projects/a/file.txt', 'Contents');
        //$posts = $this->postRepository->getActiveOrderByDate($this->nbrPages);
        $projects = $this->proRepository->getProjects(Auth::id());
        return view('pro.index')->with(['projects' => $projects]);
    }
    public function project($project)
    {
        $folder = $this->proRepository->getProject($project, Auth::id());
        //$posts = $this->postRepository->getActiveOrderByDate($this->nbrPages);
        return view('pro.project')->with(['folder' => $folder, 'project' => $project]);
    }
    public function file($project, $any)
    {
        $test = $this->proRepository->getFile($project, $any, Auth::id());
        return $test;
        # code...
    }
    public function save(Request $request, $project, $any)
    {
        $this->proRepository->saveFile($project, $request->data, $request->self, Auth::id(), $any);

    }
    public function rename(Request $request, $project, $any)
    {
        $this->proRepository->renameFile($project, $request->data, $request->self, Auth::id(), $any);
    }
    public function delete(Request $request, $project, $any)
    {
        $this->proRepository->deleteFile($project, $request->id, Auth::id(), $any);
    }
    public function new($project)
    {
        $this->proRepository->newProject($project, Auth::id());
    }
}
