<?php

namespace App\Traits;

use Illuminate\Support\Arr;
use Illuminate\Contracts\Validation\Validator;
use App\Exceptions\PassedValidationCheckException;
use App\Exceptions\FailedValidationCheckException;

trait ChecksValidation
{
    /**
     * The input key name used to determine if the validation
     * should be treated as a "check" or as normal.
     *
     * @var string
     */
    protected $checkRequestKey = "validate";

    /**
     * Determine if this request should be treated as a "check"
     *
     * @return boolean
     */
    protected function isCheckRequest() {
        return $this->request->get($this->checkRequestKey, false);
    }

    /**
     * If this is a validation "check" it means we just want to know
     * IF the supplied data would pass the validation rules without
     * triggering the rest of the logic associated with this route.
     * Therefore, to prevent a successful validation request proceeding
     * to the controller we throw a custom exception to short circuit
     * things. The exception will respond with a 200 status code to
     * let our user know their "check" was a success.
     *
     * @return void
     *
     * @throws \App\Exceptions\PassedValidationCheckException
     */
    protected function passedValidation()
    {
        if ($this->isCheckRequest()) {
            throw new PassedValidationCheckException();
        }
    }

    /**
     * Handle a failed validation attempt. Instead of using the default
     * validation exception we use a custom one here to avoid triggering
     * anything hooked into the default validation exception path.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \App\Exceptions\FailedValidationCheckException
     */
    protected function failedValidation(Validator $validator)
    {
        if ($this->isCheckRequest()) {
            throw (new FailedValidationCheckException('Validation check request failed.'))
                ->withMessages($validator->errors()->toArray());
        }

        parent::failedValidation($validator);
    }

    /**
     * This method allows us to hook into the RequestForm flow
     * before the validation takes place. If this is a "check"
     * request we modify the validator rules to only include
     * rules that pertain to the input items in this request.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        if (!$this->isCheckRequest()) {
            return;
        }

        $dotInput = Arr::dot($this->all());

        $checkRules = collect($this->rules())
            ->intersectByKeys($dotInput)
            ->toArray();

        $validator->setRules($checkRules);
    }
}
