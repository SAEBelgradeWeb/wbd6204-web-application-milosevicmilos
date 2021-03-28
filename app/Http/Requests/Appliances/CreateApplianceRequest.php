<?php

namespace App\Http\Requests\Appliances;

use App\Http\Requests\Traits\AuthorizeUserAction;
use App\Models\ApplianceType;
use App\Repositories\RoomRepository;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

/**
 * @property int $user_id
 */
final class CreateApplianceRequest extends FormRequest
{
    use AuthorizeUserAction;

    /**
     * @param RoomRepository $roomRepository
     * @return bool
     */
    public function authorize(RoomRepository $roomRepository): bool
    {
        if ( ! $this->exists('room_id') || $this->room_id < 1) {
            return true;
        }

        return $this->authorizeRoomManagement($roomRepository, $this->room_id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'room_id' => ['required', 'integer', 'min:1'],
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'appliance_type_id' => 'exists:' . ApplianceType::class . ',id'
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
