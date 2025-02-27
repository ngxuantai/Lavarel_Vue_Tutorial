<?php

namespace App\Repositories\Project;

use App\Models\Project;
use App\Repositories\RepositoryInterface;
use Illuminate\Http\Request;

interface ProjectRepositoryInterface extends RepositoryInterface
{
    /**
     * Get list project
     * @param Request $request
     * @return mixed 
     */
    public function getListProject(Request $request);

    /**
     * Create project
     * @param Request $request
     * @return mixed
     */
    public function createProject(Request $request);

    /**
     * Update project
     * @param Request $request
     * @param Project $project
     * @return mixed
     */
    public function updateProject(Request $request, Project $project);
}