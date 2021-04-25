<?php

namespace App\Http\Requests\Statistics;

use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

final class FilterStatisticsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'user_id' => ['integer', 'min:1'],
            'building_id' => ['integer', 'min:1'],
            'floor_id' => ['integer', 'min:1'],
            'room_id' => ['integer', 'min:1'],
            'appliance_id' => ['integer', 'min:1'],
        ];
    }

    public function passedValidation(): void
    {
        if ($this->user()->hasRole(User::ROLE_REGULAR)) {
            $this['user_id'] = $this->user()->id;
        }
        if ( ! $this->exists('user_id')) {
            $this['user_id'] = null;
        }
        if ( ! $this->exists('building_id')) {
            $this['building_id'] = null;
        }
        if ( ! $this->exists('floor_id')) {
            $this['floor_id'] = null;
        }
        if ( ! $this->exists('room_id')) {
            $this['room_id'] = null;
        }
        if ( ! $this->exists('appliance_id')) {
            $this['appliance_id'] = null;
        }
    }

    /**
     * @param Validator $validator
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new ValidationException($validator);
    }
}