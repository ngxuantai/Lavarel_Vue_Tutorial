<?php

namespace App\Repositories\User;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\BaseRepository;
use App\Http\Controllers\Concerns\Paginatable;
use App\Http\Controllers\Concerns\Searchable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
  use Paginatable, Searchable;

  /**
   * get model
   * @return string
   */
  public function getModel()
  {
    return User::class;
  }

  /**
   * get user list
   * @param Request $request
   * @return void
   */
  public function getUserList(Request $request)
  {
    try {
      $keyword = $request->keyword;
      $status = $request->status;
      // get new record lastest
      $query = User::withTrashed()->with(['certificates' => function ($query) {
        $query->latest();
      }])->where('type', $request->type);

      if (isset($keyword)) {
        $keyword = preg_replace('/\s+/', '', $keyword);
        $query->where(function ($q) use ($keyword) {
          $q->where(DB::raw("CONCAT(last_name, first_name)"), 'like', "%$keyword%")
            ->orWhere(DB::raw("CONCAT(last_name_kana, first_name_kana)"), 'like', "%$keyword%");
        });
      }

      if (isset($status)) {
        $query->where('status', $status);
      }

      return $query->paginate($this->getPerPage());
    } catch (Exception $ex) {
      Log::error('get user list: ' . $ex);
      return false;
    }
  }

  /**
   * create user
   * @return mixed
   */
  public function createUser(Request $request)
  {
    DB::beginTransaction();
    try {
      $data = $request->all();
      if (isset($data['password'])) {
        $data['password'] = Hash::make($data['password']);
      }
      if ($request->hasFile('avatar')) {
        $data['avatar'] = Storage::putFile('avatars', $request->avatar);
      }
      $user = $this->model->create($data);
      DB::commit();
      return $user;
    } catch (Exception $ex) {
      DB::rollBack();
      Log::error('Create user: ' . $ex);
      return false;
    }
  }

  /**
   * update user
   * @return mixed
   */
  public function updateUser(Request $request, User $user)
  {
    DB::beginTransaction();
    try {
      $data = $request->all();
      if (isset($data['password'])) {
        $data['password'] = Hash::make($data['password']);
      }
      if ($request->hasFile('avatar')) {
        $data['avatar'] = Storage::putFile('avatars', $request->avatar);
      }
      $user->update($data);
      DB::commit();
      return $user;
    } catch (Exception $ex) {
      DB::rollBack();
      Log::error('Update user: ' . $ex);
      return false;
    }
  }

  /**
   * get number users by time
   * @param Request $request
   * @return void
   */
  public function getNumberUserByTime(Request $request)
  {
    $from = Carbon::parse($request->from);
    $to = Carbon::parse($request->to);
    if ($from->equalTo($to)) {
      $query = User::whereDate('created_at', $from->toDateString())->where('type', $request->type);
    } else {
      $query = User::whereBetween('created_at', [$from, $to])->where('type', $request->type);
    }
    return $query->count();
  }
}
