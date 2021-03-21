<?php

namespace App\Http\Requests\Buildings;

use App\Models\User;
use App\Repositories\BuildingRepository;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * @property integer $id
 */
final class UpdateBuildingRequest extends FormRequest
{
    /**
     * @param BuildingRepository $buildingRepository
     * @return bool
     */
    public function authorize(BuildingRepository $buildingRepository): bool
    {
        $building = $buildingRepository->get($this->building);

        if( ! $this->user()->can('manage', $building)) {
            throw new HttpException(404, 'That building doesn\'t have exist.');
        }

        return true;
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
            'name' => ['required', 'min:3', 'max:255'],
            'address' => ['required', 'min:3', 'max:255'],
        ];
    }

    public function passedValidation(): void
    {
        if ($this->user()->hasRole(User::ROLE_REGULAR)) {
            $this['user_id'] = $this->user()->id;
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
