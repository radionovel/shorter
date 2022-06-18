<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\LinksRepositoryInterface;
use App\Contracts\Services\LinksServiceInterface;
use App\Http\Requests\CreateLinksRequest;
use App\Http\Requests\LinksRequest;
use App\Http\Requests\PatchLinksRequest;
use Illuminate\Http\JsonResponse;

class LinksController extends Controller
{
    private LinksRepositoryInterface $linksRepository;

    /**
     * @param LinksRepositoryInterface $linksRepository
     */
    public function __construct(LinksRepositoryInterface $linksRepository)
    {
        $this->linksRepository = $linksRepository;
    }

    /**
     * @param CreateLinksRequest $request
     * @param LinksServiceInterface $linksService
     * @return JsonResponse
     */
    public function store(CreateLinksRequest $request, LinksServiceInterface $linksService): JsonResponse
    {
        if($linksService->storeCollection($request->links())){
            return response()->json([], 201);
        }

        return response()->json([], 422);
    }

    /**
     * @param int $id
     * @param PatchLinksRequest $request
     * @return JsonResponse
     */
    public function patch(int $id, PatchLinksRequest $request): JsonResponse
    {
        $this->linksRepository->update($id, $request->all());
        return response()->json([]);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function link(int $id): JsonResponse
    {
        $links = $this->linksRepository->find($id);
        return response()->json($links);
    }

    /**
     * @param LinksRequest $request
     * @return JsonResponse
     */
    public function list(LinksRequest $request): JsonResponse
    {
        $links = $this->linksRepository->list($request->all());
        return response()->json($links);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->linksRepository->delete($id);
        return response()->json([], 204);
    }
}
