<?php

namespace App\Services\amoCRM\Strategy\Bizon;

use AmoCRM\Models\ContactModel;
use AmoCRM\Models\LeadModel;
use App\Models\Api\Integrations\Bizon\BizonSetting;
use App\Models\Api\Integrations\Bizon\Viewer;

interface StrategyInterface
{
    public function setApiClient($apiClient);

    public function searchContact(string $search_search_query);

    public function searchLeads(ContactModel $contactModel);

    public function createLead(ContactModel $contactModel, Viewer $viewer, BizonSetting $setting);

    public function createContact(Viewer $viewer);

    public function addLeadNote(LeadModel $lead, string $text);

    public function addLeadTags(LeadModel $lead, array $tags);

    public function updateLead(LeadModel $lead, Viewer $viewer, BizonSetting $setting);
}