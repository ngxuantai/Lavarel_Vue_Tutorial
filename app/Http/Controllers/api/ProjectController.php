<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Repositories\Project\ProjectRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Exception;

class ProjectController extends Controller
{
    protected $projectRepo;

    public function __construct(ProjectRepositoryInterface $projectRepo)
    {
        $this->projectRepo = $projectRepo;
    }

    /**
     * Display a list project
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            return response()->json($this->projectRepo->getListProject($request));
        } catch (Exception $e) {
            Log::error('Get list Project: ' . $e);
            return response()->json(['error' => 'Get list failed.'], 500);
        }
    }

    /**
     * Create a new project
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            return response()->json($this->projectRepo->createProject($request));
        } catch (Exception $e) {
            Log::error('Create Project: ' . $e);
            return response()->json(['error' => 'Create failed.'], 500);
        }
    }

    /**
     * Update project
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        try {
            $result = $this->projectRepo->updateProject($request, $project);
            if (!$result) {
                return response()->json(['error' => 'Update failed'], 500);
            }
            return response()->json($result);
        } catch (Exception $e) {
            Log::error('Create Project: ' . $e);
            return response()->json(['error' => 'Update failed'], 500);
        }
    }
}