<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class HookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'add'      => 'required|array',
            'add.0.id' => 'required|integer',
            'add.0.pipeline_id' => Rule::in([env('DISTRIBUTION_PIPELINE_ID')])
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        Log::error(__METHOD__, (array)response()->json($validator->errors()));
    }
}
