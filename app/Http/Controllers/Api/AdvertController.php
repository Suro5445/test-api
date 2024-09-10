<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdvertRequest;
use App\Http\Resources\AdvertResource;
use App\Services\AdvertService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class AdvertController extends Controller
{
    private AdvertService $advertService;

    public function __construct(AdvertService $advertService)
    {
        $this->advertService = $advertService;
    }

    /**
     * Get a paginated list of adverts.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $filters = $request->only(['sort_by', 'sort_direction']);
        $adverts = $this->advertService->getAdverts($filters);

        return AdvertResource::collection($adverts);
    }

    /**
     * Get a specific advert.
     *
     * @param Request $request
     * @param int $id
     * @return AdvertResource
     */
    public function show(Request $request, $id)
    {
        $advert = $this->advertService->getAdvertById($id);
        return new AdvertResource($advert);
    }


    /**
     * Create a new advert.
     *
     * @param AdvertRequest $request
     * @return JsonResponse
     */
    public function store(AdvertRequest $request)
    {
        try {
            $advert = $this->advertService->createAdvert($request->validated());

            return response()->json([
                'id' => $advert->id,
                'message' => 'Advert created successfully',
            ], 201);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 500);
        }
    }


}
