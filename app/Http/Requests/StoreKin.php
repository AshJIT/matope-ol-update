<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Carbon\Carbon;

class StoreKin extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'unique:kin,name', 'max:255'],
            'slug' => ['required', 'unique:kin,slug', 'max:255'],
            'current_image_url' => ['required'],
            'mother_id' => ['nullable', 'exists:kin,id'],
            'father_id' => ['nullable', 'exists:kin,id'],
            'species_id' => ['required', 'numeric'],
            'owner_id' => ['required', 'numeric'],
            'colourist_id' => ['required', 'numeric'],
            'birthdate' => ['required', 'date'],
            'gender_id' => ['required', 'numeric']
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
            'name' => trim($this->name),
            'slug' => Str::slug($this->name, '-'),
            'mother_id' => $this->mother ? $this->mother['id'] : null,
            'father_id' => $this->father ? $this->father['id'] : null,
            'birthdate' => Carbon::parse($this->birthdate)->format('Y-m-d'),
            'species_id' => $this->species['id'],
            'owner_id' => $this->owner['id'],
            'colourist_id' => $this->colorist['id'],
            'gender_id' => $this->gender['id'],
            'current_image_url' => $this->img_url
        ]);
    }
}