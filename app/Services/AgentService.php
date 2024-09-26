<?php

namespace App\Services;

use App\Http\Requests\Agent\DestroyRequest;
use App\Http\Requests\Agent\IndexRequest;
use App\Http\Requests\Agent\StoreRequest;
use App\Http\Requests\Agent\UpdateRequest;
use App\Http\Requests\Agent\BatchDestroyRequest;
use App\Http\Requests\Agent\BatchRestoreRequest;
use App\Http\Requests\Agent\RestoreRequest;
use App\Models\Agent;
use App\Http\Resources\AgentCollection;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Throwable;

class AgentService extends Service
{
    protected array $indexColumns = ['*'];

    public function index(IndexRequest $request): array
    {
        $pageSize = $request->input(config('app.page_size_name'), config('app.default_page_size'));
        $query = Agent::query()->filter($request->input(config('app.filters'), []));
        $lengthAwarePaginator = $query->paginate($pageSize, $this->indexColumns, config('app.page_name'));
        $list = new AgentCollection($lengthAwarePaginator);
        return [
            'list' => $list,
            'pagination' => $this->getApiPaginate($lengthAwarePaginator)
        ];
    }

    /**
     * @throws Throwable
     */
    public function store(StoreRequest $request, Agent $agent): Agent
    {
        return DB::transaction(function() use ($request, $agent) {
            $validated = $request->validated();
            $agent->fill($validated);
            $agent->save();
            return $agent;
        });
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateRequest $request, Agent $agent): Agent
    {
        return DB::transaction(function() use ($request, $agent) {
            $validated = $request->validated();
            $agent->fill($validated);
            $agent->save();
            return $agent;
        });
    }

    /**
     * @throws Throwable
     */
    public function destroy(DestroyRequest $request, Agent $agent): Agent
    {
        return DB::transaction(function() use ($request, $agent) {
            Agent::deleteTokens($agent->id); // 删除用户的所有 token
            $agent->delete();
            return $agent;
        });
    }

    /**
     * @throws Throwable
     */
    public function restore(RestoreRequest $request, Agent $agent): Agent
    {
        return DB::transaction(function() use ($request, $agent) {
            $agent->restore();
            return $agent;
        });
    }

    /**
     * @throws Throwable
     */
    public function batchDestroy(BatchDestroyRequest $request): int
    {
        return DB::transaction(function() use ($request) {
            $ids = $request->input('ids', []);
            Agent::deleteTokens($ids); // 删除用户的所有 token
            return Agent::whereIn('id', $ids)->delete();
        });
    }

    /**
     * @throws Throwable
     */
    public function batchRestore(BatchRestoreRequest $request): int
    {
        return DB::transaction(function() use ($request) {
            $ids = $request->input('ids', []);
            return Agent::withTrashed()->whereIn('id', $ids)->restore();
        });
    }
}
