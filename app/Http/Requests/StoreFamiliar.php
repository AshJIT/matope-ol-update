<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use App\Traits\ChecksValidation;
use Carbon\Carbon;
use App\Models\Familiar;
use App\Models\Kin;

class StoreFamiliar extends FormRequest
{
    use ChecksValidation;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'current_image_url' => 'required',
            'familiar_species_id' => 'required|numeric',
            'kin_id' => 'nullable|numeric',
            'owner_id' => 'required|numeric',
            'colourist_id' => 'nullable|numeric',
            'cert_url' => 'required',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'name' => $this->name ? trim($this->name) : null,
            'familiar_species_id' => $this->familiar_species ? $this->familiar_species['id'] : null,
            'kin_id' => $this->kin ? $this->kin['id'] : null,
            'owner_id' => $this->kin ? Kin::where('id', $this->kin['id'])->first()->owner_id : ($this->owner ? $this->owner['id'] : null),
            'colourist_id' => $this->colorist ? $this->colorist['id'] : null,
            'current_image_url' => $this->current_image_url ? $this->current_image_url : null,
            'cert_url' => $this->cert_url ? $this->cert_url : null
        ]);
    }
}