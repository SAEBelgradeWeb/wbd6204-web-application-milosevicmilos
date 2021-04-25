<?php

namespace App\Http\Controllers;

use App\Repositories\ApplianceTypeRepository;
use Illuminate\Http\JsonResponse;

final class ApplianceTypeController extends Controller
{
    /**
     * @var ApplianceTypeRepository
     */
    private $applianceTypeRepository;

    /**
     * ApplianceTypeController constructor.
     * @param ApplianceTypeRepository $applianceTypeRepository
     */
    public function __construct(ApplianceTypeRepository $applianceTypeRepository)
    {
        $this->applianceTypeRepository = $applianceTypeRepository;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'appliance_types' => $this->applianceTypeRepository->getAll()->toArray()
        ]);
    }
}
