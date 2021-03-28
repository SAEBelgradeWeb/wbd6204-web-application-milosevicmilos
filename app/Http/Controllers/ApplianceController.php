<?php

namespace App\Http\Controllers;

use App\Http\Requests\Appliances\CreateApplianceRequest;
use App\Http\Requests\Appliances\FilterAppliancesRequest;
use App\Http\Requests\Appliances\UpdateApplianceRequest;
use App\Repositories\ApplianceRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class ApplianceController extends Controller
{
    /**
     * @var ApplianceRepository
     */
    private $applianceRepository;

    /**
     * ApplianceRepository constructor.
     * @param ApplianceRepository $applianceRepository
     */
    public function __construct(ApplianceRepository $applianceRepository)
    {
        $this->applianceRepository = $applianceRepository;
    }

    /**
     * @param FilterAppliancesRequest $request
     * @return JsonResponse
     */
    public function index(FilterAppliancesRequest $request): JsonResponse
    {
        return response()->json([
            'appliances' => $this->applianceRepository->getFilteredAppliances($request->all())->toArray()
        ]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $appliance = $this->applianceRepository->get($id);

        if( ! $request->user()->can('manage', $appliance)) {
            throw new HttpException(404, 'That appliance doesn\'t have exist.');
        }

        return response()->json(['appliance' => $appliance]);
    }

    /**
     * @param CreateApplianceRequest $request
     * @return JsonResponse
     */
    public function store(CreateApplianceRequest $request): JsonResponse
    {
        return response()->json([
            'appliance' => $this->applianceRepository->create($request->all())
        ], 201);
    }

    /**
     * @param UpdateApplianceRequest $request
     * @param int $id
     * @return JsonResponse
     * @throws HttpException
     */
    public function update(UpdateApplianceRequest $request, int $id): JsonResponse
    {
        return response()->json([
            'appliance' => $this->applianceRepository->update($id, $request->all())
        ]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $appliance = $this->applianceRepository->get($id);

        if( ! $request->user()->can('manage', $appliance)) {
            throw new HttpException(404, 'That appliance doesn\'t have exist.');
        }

        $this->applianceRepository->delete($id);

        return response()->json([], 204);
    }
}
