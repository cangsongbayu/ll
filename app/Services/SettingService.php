<?php

namespace App\Services;

use App\Http\Requests\Setting\DestroyRequest;
use App\Http\Requests\Setting\IndexRequest;
use App\Http\Requests\Setting\StoreRequest;
use App\Http\Requests\Setting\UpdateRequest;
use App\Models\Setting;
use App\Http\Resources\SettingCollection;
use Illuminate\Support\Facades\DB;
use Throwable;

class SettingService extends Service
{
    protected array $indexColumns = ['*'];

    public function index(IndexRequest $request): array
    {
        $pageSize = $request->input(config('app.page_size_name'), config('app.default_page_size'));
        $query = Setting::query()->filter($request->all());
        $lengthAwarePaginator = $query->paginate($pageSize, $this->indexColumns, config('app.page_name'));
        $list = new SettingCollection($lengthAwarePaginator);
        return [
            'list' => $list,
            'pagination' => $this->getApiPaginate($lengthAwarePaginator)
        ];
    }

    /**
     * @throws Throwable
     */
    public function store(StoreRequest $request, Setting $setting): Setting
    {
        return DB::transaction(function() use ($request, $setting) {
            $validated = $request->validated();
            $setting->fill($validated);
            $setting->save();
            return $setting;
        });
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateRequest $request, Setting $setting): Setting
    {
        return DB::transaction(function() use ($request, $setting) {
            $validated = $request->validated();
            $setting->fill($validated);
            $setting->save();
            return $setting;
        });
    }

    /**
     * @throws Throwable
     */
    public function destroy(DestroyRequest $request, Setting $setting): Setting
    {
        return DB::transaction(function() use ($request, $setting) {
            $setting->delete();
            return $setting;
        });
    }
}
