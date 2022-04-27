<?php

namespace App\Services\amoCRM\Actions;

use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use AmoCRM\Models\LeadModel;
use App\Services\amoCRM\Client;

/**
 * Статический класс - реализация запроса сделки
 */
abstract class GetOneLead
{
    /**
     * @throws AmoCRMApiException
     * @throws AmoCRMoAuthApiException
     * @throws AmoCRMMissedTokenException
     */
    public static function searchLead(AmoCRMApiClient $amoApi, ?int $lead_id) : LeadModel
    {
        return $amoApi->leads()->getOne($lead_id);
    }
}
