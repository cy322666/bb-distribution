<?php

namespace App\Http\Controllers;

use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use AmoCRM\Models\LeadModel;
use App\Http\Requests\HookRequest;
use App\Models\Lead;
use App\Services\amoCRM\Validations\CheckHookTest;
use Carbon\Carbon;

class DistributionController extends Controller
{
    /**
     * Получает хук по созданной сделке в amoCRM.
     * Создает запись в leads -> запускается LeadObserver->created()
     *
     * @param HookRequest $request
     * @return void
     * @throws AmoCRMApiException
     * @throws AmoCRMMissedTokenException
     * @throws AmoCRMoAuthApiException
     */
    public function hook(HookRequest $request)
    {
        $lead = $this->amoApi
            ->leads()
            ->getOne(
                $request->validated()['add'][0]['id'],
                [LeadModel::CONTACTS]
            );

        $contact = $this->amoApi
            ->contacts()
            ->getOne($lead->getMainContact()->getId());

        Lead::query()->create([
            'lead_id' => $lead->getId(),
            'name'    => $lead->getName(),
            'created' => Carbon::parse($lead->getCreatedAt())->format('Y-m-d H:i:s'),
            'price'   => $lead->getPrice(),
            'status_id' => $lead->getStatusId(),
            'created_user_id' => $lead->getCreatedBy(),
            'responsible_user_id' => $lead->getResponsibleUserId(),

            'custom_fields' => json_encode($lead->getCustomFieldsValues()->toArray()),

            'contact_id' => $lead->getMainContact()?->getId(),
            'contact_responsible_user_id' => $contact?->getResponsibleUserId(),
            'contact_created' => Carbon::parse($contact?->getCreatedAt())->format('Y-m-d H:i:s'),

            'tags' => json_encode($lead->getTags()->toArray()),

            'is_test' => (new CheckHookTest())
                ->setContact($contact)
                ->setLead($lead)
                ->validate(),
        ]);
    }
}
