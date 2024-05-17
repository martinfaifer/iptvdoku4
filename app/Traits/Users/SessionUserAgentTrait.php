<?php

namespace App\Traits\Users;

use Illuminate\Support\Facades\Auth;

trait SessionUserAgentTrait
{
    public function agents(): array
    {
        $agents = [];
        $sessions = Auth::user()->sessions;

        if (is_null($sessions)) {
            return $agents;
        }

        foreach ($sessions as $session) {
            $agents[] = [
                'id' => $session->id,
                'device' => [
                    'browser' => $this->get_browser($session->user_agent),
                    'isDesktop' => $this->isDesktop($session->user_agent),
                    'isMobile' => $this->isMobile($session->user_agent),
                    'platform' => $this->get_platform($session->user_agent)
                ],
                'ip_address' => $session->ip_address,
                'last_active' => $session->last_activity->diffForHumans()
            ];
        }

        return $agents;
    }

    public function isDesktop(string $agent): bool
    {
        if (str_contains($agent, "iPhone")) {
            return false;
        }

        if (str_contains($agent, "Android")) {
            return false;
        }

        return true;
    }

    public function isMobile(string $agent): bool
    {
        if (str_contains($agent, "iPhone")) {
            return true;
        }

        if (str_contains($agent, "Android")) {
            return true;
        }

        return false;
    }

    public function get_browser(string $agent): string
    {
        if (str_contains($agent, "Chrome")) {
            return "Chrome";
        }

        if (str_contains($agent, "Firefox")) {
            return "Firefox";
        }

        if (str_contains($agent, "Opera")) {
            return "Opera";
        }

        if (str_contains($agent, "Edge")) {
            return "Edge";
        }

        return "Nezmáný prohlížeč";
    }

    public function get_platform(string $agent): string
    {
        if (str_contains($agent, "OS X")) {
            return "OS X";
        }

        if (str_contains($agent, "iPhone")) {
            return "iPhone";
        }

        if (str_contains($agent, "Windows")) {
            return "Windows";
        }

        if (str_contains($agent, "Linux")) {
            return "Linux";
        }

        if (str_contains($agent, "Android")) {
            return "Android";
        }

        return "Neznámý";
    }
}
