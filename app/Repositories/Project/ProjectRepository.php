<?php

namespace App\Repositories\Project;

use App\Models\Project;
use Exception;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProjectRepository extends BaseRepository implements ProjectRepositoryInterface
{
    /**
     * get model
     * 
     */
    public function getModel()
    {
        return Project::class;
    }

    /**
     * Get list project
     * @param Request $request
     * @return 
     */
    public function getListProject(Request $request)
    {
        try {
            $query = Project::query()->orderBy('created_at', 'desc');
            return $query;
        } catch (Exception $e) {
            Log::error('Get list project: ' . $e);
            return false;
        }
    }

    /**
     * Create project
     * @param Request $request
     * @return mixed
     */
    public function createProject(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $project = $this->model->create($data);
            DB::commit();
            return $project;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Create project: ' . $e);
            return false;
        }
    }

    public function updateProject(Request $request, Project $project)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $project->update($data);
            DB::commit();
            return $project;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Update project: ' . $e);
            return false;
        }
    }
}