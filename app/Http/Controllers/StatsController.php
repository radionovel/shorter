<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\Repositories\LinkViewsRepositoryInterface;
use App\Exceptions\LinkNotFound;
use App\Http\Requests\StatsRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StatsController extends Controller
{

    /**
     * @param LinkViewsRepositoryInterface $linkViewsRepository
     */
    public function __construct(protected LinkViewsRepositoryInterface $linkViewsRepository)
    {
    }

    /**
     * @param int $linkId
     * @param Request $request
     * @return JsonResponse
     */
    public function linkStats(int $linkId, Request $request): JsonResponse
    {
        try {
            $stat = $this->linkViewsRepository->linkStats($linkId, $request->get('page', 1));
        } catch (LinkNotFound $exception) {
            return response()->json(['message' => $exception->getMessage()], 404);
        }

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
