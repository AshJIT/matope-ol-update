<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use App\Traits\ChecksValidation;
use Carbon\Carbon;
use App\Models\Kin;

class StoreKin extends FormRequest
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
            'slug' => 'required|max:255|unique:kin,slug,' . $this->kin->id,
            'current_image_url' => 'required',
            'mother_id' => 'nullable|exists:kin,id',
            'father_id' => 'nullable|exists:kin,id',
            'species_id' => 'required|numeric',
            'owner_id' => 'required|numeric',
            'colourist_id' => 'required|numeric',
            'birthdate' => 'required|date',
            'gender_id' => 'required|numeric'
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
            'slug' => trim($this->name) === "Totoma" ? 'totoma-' . (Kin::where('species_id', 2)->count() + 1) : Str::slug($this->name, '-'),
            'mother_id' => $this->mother ? $this->mother['id'] : null,
            'father_id' => $this->father ? $this->father['id'] : null,
            'birthdate' => $this->birthdate ? Carbon::parse($this->birthdate)->format('Y-m-d') : null,
            'species_id' => $this->species ? $this->species['id'] : null,
            'owner_id' => $this->owner ? $this->owner['id'] : null,
            'colourist_id' => $this->colorist ? $this->colorist['id'] : null,
            'gender_id' => $this->gender ? $this->gender['id'] : null,
            'current_image_url' => $this->img_url ? $this->img_url : null
        ]);
    }
}