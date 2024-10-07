<?php

namespace App\Observers;

use App\Models\Agent;

class AgentObserver
{
    /**
     * Handle the Agent "created" event.
     */
    public function created(Agent $agent): void
    {
        //
    }

    public function updating(Agent $agent): void
    {
        // 确保用户关闭双因素认证时，清空双因素认证相关字段
        if ($agent->isDirty('is_enable_tfa') && !$agent->is_enable_tfa) {
            $agent->tfa_secret = null;
            Agent::deleteTokens($agent->id);
        }

        // 如果用户修改了密码，删除用户的所有 token
        if ($agent->isDirty('password')) {
            Agent::deleteTokens($agent->id);
        }
    }

    /**
     * Handle the Agent "updated" event.
     */
    public function updated(Agent $agent): void
    {
        //
    }

    /**
     * Handle the Agent "deleted" event.
     */
    public function deleted(Agent $agent): void
    {
        //
        Agent::deleteTokens($agent->id); // 删除用户的所有 token
    }

    /**
     * Handle the Agent "restored" event.
     */
    public function restored(Agent $agent): void
    {
        //
    }

    /**
     * Handle the Agent "force deleted" event.
     */
    public function forceDeleted(Agent $agent): void
    {
        //
    }
}
