<?php

namespace App\Services\amoCRM\Validations;

use AmoCRM\Models\ContactModel;
use AmoCRM\Models\LeadModel;

final class CheckHookTest
{
    private ?LeadModel $lead;
    private ?ContactModel $contact;

    public function setContact(?ContactModel $model)
    {
        $this->contact = $model;

        return $this;
    }

    public function setLead(?LeadModel $model)
    {
        $this->lead = $model;

        return $this;
    }

    public function validate() : bool
    {
        $this->validateContactEmail();


    }

    private function validateContactEmail() : bool
    {
        if($this->contact !== null) {

            $array_fields = $this->contact->getCustomFieldsValues()->toArray();
            dd($array_fields);
        }


        $haystack = 'ababcd';
        $needle   = 'aB';

        $pos      = strripos($haystack, $needle);

        if ($pos === false) {
            echo "К сожалению, ($needle) не найдена в ($haystack)";
        } else {
            echo "Поздравляем!\n";
            echo "Последнее вхождение ($needle) найдено в ($haystack) в позиции ($pos)";
        }
    }
}
