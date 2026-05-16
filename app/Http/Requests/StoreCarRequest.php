<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Car::class);
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('reg_number')) {
            $raw = (string) $this->input('reg_number');
            $trimmed = trim($raw);
            $spaces = preg_replace('/\s+/', ' ', $trimmed) ?? $trimmed;
            $upper = function_exists('mb_strtoupper')
                ? mb_strtoupper($spaces, 'UTF-8')
                : strtoupper($spaces);
            $this->merge(['reg_number' => $upper]);
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'reg_number' => [
                'required',
                'string',
                'min:3',
                'max:32',
                'regex:/^(?=.*[\p{L}\p{N}])[\p{L}\p{N}\s\-\.]+$/u',
                Rule::unique('cars', 'reg_number'),
            ],
            'brand' => ['required', 'string', 'min:2', 'max:100'],
            'model' => ['required', 'string', 'min:1', 'max:100'],
            'owner_id' => [
                'required',
                'integer',
                Rule::exists('owners', 'id')->where(function ($query) {
                    if (! $this->user()->isAdmin()) {
                        $query->where('user_id', $this->user()->id);
                    }
                }),
            ],
            'photos' => ['nullable', 'array', 'max:10'],
            'photos.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'reg_number.required' => __('validation.car.reg_number.required'),
            'reg_number.string' => __('validation.car.reg_number.string'),
            'reg_number.regex' => __('validation.car.reg_number.regex'),
            'reg_number.unique' => __('validation.car.reg_number.unique'),
            'reg_number.min' => __('validation.car.reg_number.min'),
            'reg_number.max' => __('validation.car.reg_number.max'),
            'brand.required' => __('validation.car.brand.required'),
            'brand.string' => __('validation.car.brand.string'),
            'brand.min' => __('validation.car.brand.min'),
            'brand.max' => __('validation.car.brand.max'),
            'model.required' => __('validation.car.model.required'),
            'model.string' => __('validation.car.model.string'),
            'model.min' => __('validation.car.model.min'),
            'model.max' => __('validation.car.model.max'),
            'owner_id.required' => __('validation.car.owner_id.required'),
            'owner_id.integer' => __('validation.car.owner_id.integer'),
            'owner_id.exists' => __('validation.car.owner_id.exists'),
            'photos.array' => __('validation.car.photos.array'),
            'photos.max' => __('validation.car.photos.max'),
            'photos.*.image' => __('validation.car.photos.image'),
            'photos.*.mimes' => __('validation.car.photos.mimes'),
            'photos.*.max' => __('validation.car.photos.file_max'),
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'reg_number' => __('Registration Number'),
            'brand' => __('Brand'),
            'model' => __('Model'),
            'owner_id' => __('Owner'),
            'photos' => __('Car Photos'),
        ];
    }
}
