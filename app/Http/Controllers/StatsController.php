<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\LinkViewsRepositoryInterface;
use App\Http\Requests\StatsRequest;
use Illuminate\Http\JsonResponse;

class StatsController extends Controller
{
    protected LinkViewsRepositoryInterface $linkViewsRepository;

    /**
     * @param LinkViewsRepositoryInterface $linkViewsRepository
     */
    public function __construct(LinkViewsRepositoryInterface $linkViewsRepository)
    {
        $this->linkViewsRepository = $linkViewsRepository;
    }

    /**
     * @param int $linkId
     * @return JsonResponse
     */
    public function linkStats(int $linkId): JsonResponse
    {
        $stat = $this->linkViewsRepository->linkStats($linkId);
        return response()->json($stat);
    }

    /**
     * @param StatsRequest $request
     * @return JsonResponse
     */
    public function totalStats(StatsRequest $request): JsonResponse
    {
        $stat = $this->linkViewsRepository->totalStats($request->all());
        return response()->json($stat);
    }


}
