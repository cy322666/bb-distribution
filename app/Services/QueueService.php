<?php

namespace App\Services;

use App\Models\Lead;
use App\Models\Queue;
use App\Models\Staff;
use Illuminate\Database\Eloquent\Collection;

final class QueueService
{
    private static string $corporateRequestTag = 'corporate-request';

    public function __construct(Lead $lead)
    {
        $this->staffs = Staff::query()
            ->where('status', 2)
            ->get();

        $this->lead = $lead;
    }

    public function getQueue() : Queue
    {
        $isContactStaff = $this->checkContactStaff($lead->contact_responsible_user_id);

        if ($isContactStaff === true) {

            //TODO закинуть в статистику как распределенный на своего


        }

        $isCorporateRequest = $this->checkCorporateRequest();

    }

    /**
     * Проверка является ли ответственный за контакт сделки одним из сотрудников для распределения
     *
     * @param int $responsibleUserId
     * @param Collection $staffs
     * @return bool
     */
    private function checkContactStaff(int $responsibleUserId): bool
    {
        foreach ($this->staffs as $staff) {

            if($staff->responsible_user_id == $responsibleUserId) {

                return true;
            }
        }
        return false;
    }

    private function checkCorporateRequest()
    {
        if ($this->lead->tags !== null) {

            $arrayTags = json_decode($this->lead->tags);

            foreach ($arrayTags as $arrayTag) {

                if ($arrayTag == self::$corporateRequestTag) {

                    return true;
                }
            }
        }
        return false;
    }
}
