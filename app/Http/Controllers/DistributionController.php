<?php

namespace App\Http\Controllers;

use App\Http\Requests\HookRequest;
use App\Models\Account;
use App\Models\Lead;
use App\Services\amoCRM\Client;
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
        $request_array = $request->validated()['add'][0];

        $contact = $this->amoApi
            ->leads()
            ->getOne($request_array['id'])
            ->getMainContact();

        Lead::query()->create([
            'lead_id' => $request_array['id'],
            'name'    => $request_array['name'],
            'created' => Carbon::create($request_array['date_create'])->format('Y-m-d H:i:s'),
            'price'   => $request_array['price'],
            'created_user_id'  => $request_array['created_user_id'],

            'responsible_user_id' => $request_array['responsible_user_id'],
            'custom_fields'   => $request_array[''],

            'contact_id' => $contact?->getId(),
            'contact_responsible_user_id' => Carbon::create($contact?->getCreatedAt())->format('Y-m-d H:i:s'),
            'contact_created' => $contact?->getResponsibleUserId(),

            'tags' => json_encode($request_array['tags']),

            'is_test' => '',
        ]);
    }
}
