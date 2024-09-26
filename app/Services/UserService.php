<?php

namespace App\Services;

use App\Http\Requests\User\BatchDestroyRequest;
use App\Http\Requests\User\BatchRestoreRequest;
use App\Http\Requests\User\DestroyRequest;
use App\Http\Requests\User\IndexRequest;
use App\Http\Requests\User\RestoreRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Throwable;

class UserService extends Service
{
    protected array $indexColumns = ['*'];

    public function index(IndexRequest $request): array
    {
        $pageSize = $request->input(config('app.page_size_name'), config('app.default_page_size'));
        $query = User::query()->filter($request->all());
        $lengthAwarePaginator = $query->paginate($pageSize, $this->indexColumns, config('app.page_name'));
        $list = new UserCollection($lengthAwarePaginator);
        return [
            'list' => $list,
            'pagination' => $this->getApiPaginate($lengthAwarePaginator)
        ];
    }

    /**
     * @throws Throwable
     */
    public function store(StoreRequest $request, User $user): User
    {
        return DB::transaction(function() use ($request, $user) {
            $validated = $request->validated();
            $user->fill($validated);
            $user->save();
            return $user;
        });
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateRequest $request, User $user): User
    {
        return DB::transaction(function() use ($request, $user) {
            $validated = $request->validated();
            $user->fill($validated);
            $user->save();
            return $user;
        });
    }

    /**
     * @throws Throwable
     */
    public function destroy(DestroyRequest $request, User $user): User
    {
        return DB::transaction(function() use ($request, $user) {
            User::deleteTokens($user->id); // 删除用户的所有 token
            $user->delete();
            return $user;
        });
    }

    /**
     * @throws Throwable
     */
    public function restore(RestoreRequest $request, User $user): User
    {
        return DB::transaction(function() use ($request, $user) {
            $user->restore();
            return $user;
        });
    }

    /**
     * @throws Throwable
     */
    public function batchDestroy(BatchDestroyRequest $request): int
    {
        return DB::transaction(function() use ($request) {
            $ids = $request->input('ids', []);
            User::deleteTokens($ids); // 删除用户的所有 token
            return User::whereIn('id', $ids)->delete();
        });
    }

    /**
     * @throws Throwable
     */
    public function batchRestore(BatchRestoreRequest $request): int
    {
        return DB::transaction(function() use ($request) {
            $ids = $request->input('ids', []);
            return User::withTrashed()->whereIn('id', $ids)->restore();
        });
    }
}
