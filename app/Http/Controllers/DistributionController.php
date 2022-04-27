<?php

namespace App\Http\Controllers;

use App\Http\Requests\HookRequest;
use App\Models\Account;
use App\Models\Lead;
use App\Services\amoCRM\Actions\GetOneLead;
use App\Services\amoCRM\Client;
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
     */
    public function hook(HookRequest $request)
    {
        $lead = GetOneLead::searchLead($this->amoApi, $request->validated()['add'][0]['id']);

        $contact = $lead->getMainContact();
dd($lead);
        Lead::query()->create([
            'lead_id' => $lead->getId(),
            'name'    => $lead->getName(),
            'created' => Carbon::create($lead->getCreatedAt())->format('Y-m-d H:i:s'),
            'price'   => $lead->getPrice(),
            'status_id' => $lead->getStatusId(),
            'created_user_id' => $lead->getCreatedBy(),
            'responsible_user_id' => $lead->getResponsibleUserId(),

            'custom_fields' => json_encode($lead->getCustomFieldsValues()->toArray()),

            'contact_id' => $lead->getMainContact()?->getId(),
            'contact_responsible_user_id' => Carbon::create($contact?->getCreatedAt())->format('Y-m-d H:i:s'),
            'contact_created' => $contact?->getResponsibleUserId(),

            'tags' => json_encode($lead->getTags()->toArray()),

            'is_test' => (new CheckHookTest())
                ->setContact($contact)
                ->setLead($lead)
                ->validate(),
        ]);
    }
}
