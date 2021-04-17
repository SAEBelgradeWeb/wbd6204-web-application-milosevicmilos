<?php

namespace App\Http\Requests\Buildings;

use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

/**
 * @property int $user_id
 */
final class CreateBuildingRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        if ($this->user()->hasRole(User::ROLE_REGULAR)) {
            $this['user_id'] = $this->user()->id;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer', 'min:1'],
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'address' => ['required', 'string', 'min:3', 'max:255'],
        ];
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
