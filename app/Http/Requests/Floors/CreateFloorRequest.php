<?php

namespace App\Http\Requests\Floors;

use App\Models\User;
use App\Repositories\BuildingRepository;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * @property int $user_id
 */
final class CreateFloorRequest extends FormRequest
{
    // TODO: Validate if user is REGULAR and owns the building.

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'building_id' => ['required', 'integer', 'min:1'],
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'level' => ['required', 'integer', 'min:-50', 'max:1000'],
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
