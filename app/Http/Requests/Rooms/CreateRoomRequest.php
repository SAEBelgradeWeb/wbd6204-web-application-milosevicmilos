<?php

namespace App\Http\Requests\Rooms;

use App\Http\Requests\Traits\AuthorizeUserAction;
use App\Repositories\BuildingRepository;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

/**
 * @property int $building
 * @property int $floor
 */
final class CreateRoomRequest extends FormRequest
{
    use AuthorizeUserAction;

    /**
     * @param BuildingRepository $buildingRepository
     * @return bool
     */
    public function authorize(BuildingRepository $buildingRepository): bool
    {
        return $this->authorizeUserAction($buildingRepository, $this->building);
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
            'size' => ['required', 'integer', 'min:1', 'max:1000'],
        ];
    }

    public function passedValidation(): void
    {
        $this['floor_id'] = $this->floor;
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
