<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOwnerRequest extends FormRequest
{
    /** Unicode letters, spaces, hyphen, apostrophe, period; no digits */
    private const NAME_PATTERN = '/^(?=.*\p{L})[\p{L}\s\'\-\.]+$/u';

    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Owner::class);
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => is_string($this->input('name')) ? trim($this->input('name')) : $this->input('name'),
            'surname' => is_string($this->input('surname')) ? trim($this->input('surname')) : $this->input('surname'),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:30', 'regex:'.self::NAME_PATTERN],
            'surname' => ['required', 'string', 'min:2', 'max:30', 'regex:'.self::NAME_PATTERN],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => __('validation.owner.name.required'),
            'name.string' => __('validation.owner.name.string'),
            'name.min' => __('validation.owner.name.min'),
            'name.max' => __('validation.owner.name.max'),
            'name.regex' => __('validation.owner.name.regex'),
            'surname.required' => __('validation.owner.surname.required'),
            'surname.string' => __('validation.owner.surname.string'),
            'surname.min' => __('validation.owner.surname.min'),
            'surname.max' => __('validation.owner.surname.max'),
            'surname.regex' => __('validation.owner.surname.regex'),
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => __('Name'),
            'surname' => __('Surname'),
        ];
    }
}
