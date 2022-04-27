<?php

namespace App\Http\Controllers;

use AmoCRM\Client\AmoCRMApiClient;
use App\Models\Account;
use App\Services\amoCRM\Client;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public AmoCRMApiClient $amoApi;

    public function __construct(Client $amoApi)
    {
        $this->amoApi = $amoApi->getInstance(Account::query()->first());
    }
}
