<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CountNumberUserRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\ListUsersRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * Display a listing of the resource.
     * @param ListUsersRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(ListUsersRequest $request)
    {
        try {
            $data = $this->userRepo->getUserList($request);
            return response()->json($data);
        } catch (Exception $ex) {
            Log::error('Get List user: ' . $ex);
            return response()->json(['error' => 'サーバーが不正です。'], 500);
        }
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        if (auth()->attempt($loginData)) {
            $user = auth()->user();
            $accessToken = $user->createToken('MyApp')->accessToken;

            return response()->json(
                [
                    'user' => $user,
                    'access_token' => $accessToken
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'error' => 'Unauthorised'
                ],
                401
            );
        }
    }


    /**
     * Show the form for creating a new resource.
     * @param CreateUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function create(CreateUserRequest $request)
    {
        try {
            return response()->json($this->userRepo->createUser($request));
        } catch (Exception $ex) {
            Log::error('Create User: ' . $ex);
            return response()->json(['error' => 'サーバーが不正です。'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param UpdateUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            $result = $this->userRepo->updateUser($request, $user);
            if (!$result) {
                return response()->json(
                    ['error' => 'サーバーが不正です。'],
                    400
                );
            }
            return response()->json($result);
        } catch (Exception $ex) {
            Log::error('update user Err: ' . $ex);
            return response()->json(['error' => 'サーバーが不正です。'], 500);
        }
    }

    /**
     * Detail User
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        try {
            $user = User::withTrashed()->with([
                'certificates' => function ($query) {
                    $query->orderBy('created_at', 'desc')->first();
                }
            ])->findOrFail($id);
            return response()->json($user);
        } catch (Exception $ex) {
            Log::error('Detail User: ' . $ex);
            return response()->json(['error' => 'サーバーが不正です。'], 500);
        }
    }

    /**
     * Delete user.
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function delete(User $user)
    {
        try {
            $user->status = User::STATUS_DELETE;
            $user->save();
            $user = $user->delete();
            return response()->json($user);
        } catch (Exception $ex) {
            Log::error('delete user Err: ' . $ex);
            return response()->json(['error' => 'サーバーが不正です。'], 500);
        }
    }

    /**
     * Get number users by type user
     * @param CountNumberUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function getNumberOfUsers(CountNumberUserRequest $request)
    {
        try {
            $data = $this->userRepo->getNumberUserByTime($request);
            return response()->json($data);
        } catch (Exception $ex) {
            Log::error('Get List user: ' . $ex);
            return response()->json(['error' => 'サーバーが不正です。'], 500);
        }
    }
}