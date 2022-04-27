<?php

namespace App\Observers;

use App\Models\Lead;
use App\Services\QueueService;

class LeadObserver
{
    public function created(Lead $lead)
    {
        if($lead->is_test == false) {

            if($lead->status_id !== 142) {

                (new QueueService())->getQueue($lead);

            } else {
                //TODO отправить в статистику как закрытый (оплата?)
            }
        } else {
            //TODO отправить в статистику как тестовый
        }
    }
}
