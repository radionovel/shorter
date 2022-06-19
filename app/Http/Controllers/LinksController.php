<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\LinksRepositoryInterface;
use App\Contracts\Repositories\LinkViewsRepositoryInterface;
use App\Contracts\Services\LinksServiceInterface;
use App\DTO\CreateLinkViewDto;
use App\Http\Requests\CreateLinksRequest;
use App\Http\Requests\LinksRequest;
use App\Http\Requests\PatchLinksRequest;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

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
        if ($linksService->storeCollection($request->links())) {
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
        $link = $this->linksRepository->find($id);
        return response()->json($link);
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

    /**
     * @param string $code
     * @param Request $request
     * @param LinkViewsRepositoryInterface $linkViewsRepository
     * @return RedirectResponse
     * @throws UnknownProperties
     */
    public function go(string $code, Request $request, LinkViewsRepositoryInterface $linkViewsRepository): RedirectResponse
    {
        $link = $this->linksRepository->findByCode($code);
        $linkViewsRepository->storeView(new CreateLinkViewDto([
            'link_id' => $link->id,
            'user_id' => hash('sha3-256', $request->ip() . $request->userAgent()),
            'view_date' => Carbon::now()->toDate(),
            'user_ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]));
        return response()->redirectTo($link->long_url);
    }
}
