<?php

namespace App\Traits\Slack;

use App\Models\Slack;

trait TranslateActionsTrait
{
    public function translate(): array
    {
        $actionWithTranslation = [];
        $slackActions = [];
        foreach (Slack::ACTIONS as $action) {
            if ($action == 'weather_notification') {
                $actionWithTranslation = [
                    'id' => $action,
                    'name' => 'Upozornění na počasí',
                ];
            }

            if ($action == 'gpu_problem_notification') {
                $actionWithTranslation = [
                    'id' => $action,
                    'name' => 'Upozornění na nefunkční GPU',
                ];
            }

            if ($action == 'crashed_channel') {
                $actionWithTranslation = [
                    'id' => $action,
                    'name' => 'Upozornění na nefunkční kanál',
                ];
            }

            if ($action == 'calendar_notification') {
                $actionWithTranslation = [
                    'id' => $action,
                    'name' => 'Upozornění na hromadnou událost v kalendáři',
                ];
            }

            if ($action == 'restart_channel') {
                $actionWithTranslation = [
                    'id' => $action,
                    'name' => 'Upozornění na restart kanálu',
                ];
            }

            if ($action == 'satelit_cards_expiration') {
                $actionWithTranslation = [
                    'id' => $action,
                    'name' => 'Upozornění na expiraci satelitních karet',
                ];
            }

            if ($action == 'device_error') {
                $actionWithTranslation = [
                    'id' => $action,
                    'name' => 'Upozornění na změnu/problém na zařízení',
                ];
            }

            $slackActions[] = $actionWithTranslation;
        }

        return $slackActions;
    }
}
