<?php

namespace App\Http\Requests\Floors;

use App\Http\Requests\Traits\AuthorizeUserAction;
use App\Repositories\BuildingRepository;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

/**
 * @property int $building
 */
final class CreateFloorRequest extends FormRequest
{
    use AuthorizeUserAction;

    /**
     * @param BuildingRepository $buildingRepository
     * @return bool
     */
    public function authorize(BuildingRepository $buildingRepository): bool
    {
        return $this->authorizeBuildingManagement($buildingRepository, $this->building);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'level' => ['required', 'integer', 'min:-50', 'max:1000'],
        ];
    }

    public function passedValidation(): void
    {
        $this['building_id'] = $this->building;
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
