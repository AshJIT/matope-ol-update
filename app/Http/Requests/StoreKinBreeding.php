<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ChecksValidation;
use Carbon\Carbon;

class StoreKinBreeding extends FormRequest
{
    use ChecksValidation;

    public function rules()
    {
        return [
            'mother_id' => 'required|exists:kin,id',
            'father_id' => 'required|exists:kin,id',
            'colourist_id' => 'required|numeric',
            'entries' => 'required|array|min:1',
            'entries.*.name' => 'required|max:255',
            'entries.*.current_image_url' => 'required',
            'entries.*.species_id' => 'required|numeric',
            'entries.*.owner_id' => 'required|numeric',
            'entries.*.birthdate' => 'required|date',
            'entries.*.gender_id' => 'required|numeric',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'mother_id' => data_get($this->mother, 'id'),
            'father_id' => data_get($this->father, 'id'),
            'colourist_id' => data_get($this->colorist, 'id'),
            'entries' => collect($this->entries ?? [])->map(fn ($entry) => [
                'name' => trim($entry['name'] ?? '') ?: null,
                'current_image_url' => ($entry['img_url'] ?? null) ?: null,
                'species_id' => data_get($entry, 'species.id'),
                'owner_id' => data_get($entry, 'owner.id'),
                'gender_id' => data_get($entry, 'gender.id'),
                'birthdate' => empty($entry['birthdate']) ? null : Carbon::parse($entry['birthdate'])->format('Y-m-d'),
            ])->all(),
        ]);
    }
}
