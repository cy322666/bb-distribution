<?php

namespace App\Services\amoCRM\Strategy\Bizon\Actions;

use AmoCRM\Exceptions\AmoCRMApiException;;
use AmoCRM\Models\LeadModel;
use App\Models\Api\Integrations\Bizon\BizonSetting;
use App\Models\Api\Integrations\Bizon\Viewer;
use Illuminate\Support\Facades\Log;

/**
 * Статический класс - реализация создания контакта.
 * Реализуется в стратегиях бизон
 */
abstract class BizonUpdateLead
{
    public static function updateLead(LeadModel $lead, Viewer $viewer, BizonSetting $setting, $amoApi)
    {
        try {
            $lead->setStatusId($viewer->getStatusId($setting));

            $amoApi
                ->leads()
                ->updateOne($lead);

        } catch (AmoCRMApiException $exception) {

            Log::error(__METHOD__.' : '.$exception->getTraceAsString());
        }
        return $lead;
    }
}