<?php

namespace App\Services\amoCRM\Strategy\Bizon;

use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Collections\NotesCollection;
use AmoCRM\Collections\TagsCollection;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Helpers\EntityTypesInterface;
use AmoCRM\Models\ContactModel;
use AmoCRM\Models\LeadModel;
use AmoCRM\Models\NoteType\CommonNote;
use AmoCRM\Models\TagModel;
use App\Models\Api\Integrations\Bizon\BizonSetting;
use App\Models\Api\Integrations\Bizon\Viewer;
use App\Services\amoCRM\Strategy\Actions\CreateContact;
use App\Services\amoCRM\Strategy\Actions\CreateLead;
use App\Services\amoCRM\Strategy\Actions\SearchContact;
use App\Services\amoCRM\Strategy\Actions\SearchLead;
use App\Services\amoCRM\Strategy\Bizon\Actions\BizonUpdateLead;
use Illuminate\Support\Facades\Log;
use AmoCRM\Models\NoteModel;

class UniteLeads implements StrategyInterface
{
    private AmoCRMApiClient $apiClient;
    private BizonSetting $setting;

    /**
     * @param BizonSetting $setting
     */
    public function __construct(BizonSetting $setting)
    {
        $this->setting = $setting;
    }

    public function setApiClient($apiClient): static
    {
        $this->apiClient = $apiClient;

        return $this;
    }

    public function getSetting(): BizonSetting
    {
        return $this->setting;
    }

    public function createContact(Viewer $viewer): bool|ContactModel
    {
        return CreateContact::createContact($viewer, $this->apiClient);
    }

    public function searchContact($search_query): ?ContactModel
    {
        return SearchContact::searchContact($this->apiClient, $search_query);
    }

    /**
     * @param ContactModel $contactModel
     * @return mixed|null
     */
    public function searchLeads(ContactModel $contactModel): ?LeadModel
    {
        return SearchLead::searchLead($contactModel);
    }

    public function createLead(ContactModel $contactModel, Viewer $viewer, BizonSetting $setting): LeadModel
    {
        return CreateLead::createLead($contactModel, $viewer, $setting, $this->apiClient);
    }

    public function updateLead(LeadModel $lead, Viewer $viewer, BizonSetting $setting): LeadModel
    {
        return BizonUpdateLead::updateLead($lead, $viewer, $setting, $this->apiClient);
    }

    public function addLeadNote(LeadModel $lead, string $text): ?NoteModel
    {
        $serviceMessageNote = (new CommonNote())
            ->setEntityId($lead->getId())
            ->setText($text)
            ->setCreatedBy(0);//TODO?

        $notesCollection = (new NotesCollection())->add($serviceMessageNote);

        try {
            $leadNotesService = $this->apiClient
                ->notes(EntityTypesInterface::LEADS);

            $notesCollection = $leadNotesService->add($notesCollection);

            return $notesCollection->first();

        } catch (AmoCRMApiException $exception) {

            Log::error(__METHOD__.' : '.$exception->getTraceAsString());
        }
    }

    public function addLeadTags(LeadModel $lead, array $tags)
    {
        $tagsCollection = new TagsCollection();

        foreach ($tags as $tag) {

            if($tag !== null)
                $tagsCollection->add(
                    (new TagModel())->setName($tag)
                );
        }

        try {
            $lead->setTags($tagsCollection);

            $this->apiClient->leads()->updateOne($lead);

        } catch (AmoCRMApiException $exception) {

            Log::error(__METHOD__.' : '.$exception->getTraceAsString(), $exception->getValidationErrors());
        }
    }
}