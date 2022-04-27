<?php

namespace App\Services\amoCRM\Strategy\Bizon;

use App\Models\Api\Integrations\Bizon\BizonSetting;
use App\Services\amoCRM\Strategy\Bizon\UniteLeads;

class SendFactory
{
    /**
     * @param string $strategy_name
     * @param BizonSetting $setting
     * @return \App\Services\amoCRM\Strategy\Bizon\UniteLeads|string
     *
     * исходя из названия стратегии отдает класс реализации
     */
    public static function getStrategy(string $strategy_name, BizonSetting $setting)
    {
        return match ($strategy_name) {

            'test'      => '',
            default => new UniteLeads($setting),
        };
    }
}