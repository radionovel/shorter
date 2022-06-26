<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\Repositories\LinksRepositoryInterface;
use App\Contracts\Repositories\LinkViewsRepositoryInterface;
use App\Contracts\Services\LinksServiceInterface;
use App\Exceptions\LinkNotFound;
use App\Factories\LinkViewFactoryInterface;
use App\Http\Requests\CreateLinksRequest;
use App\Http\Requests\LinksRequest;
use App\Http\Requests\PatchLinksRequest;
use Carbon\CarbonImmutable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LinksController extends Controller
{
    /**
     * @param LinksRepositoryInterface $linksRepository
     */
    public function __construct(protected LinksRepositoryInterface $linksRepository)
    {
    }

    /**
     * @param CreateLinksRequest $request
     * @param LinksServiceInterface $linksService
     * @return JsonResponse
     */
    public function store(CreateLinksRequest $request, LinksServiceInterface $linksService): JsonResponse
    {
        if ($ids = $linksService->storeCollection($request->links())) {
            return response()->json($ids, 201);
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
        try {
            $this->linksRepository->update($id, $request->all());
        } catch (LinkNotFound $exception) {
            return response()->json(['message' => $exception->getMessage()], 404);
        }

        return response()->json([]);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function link(int $id): JsonResponse
    {
        try {
            $link = $this->linksRepository->find($id);
        } catch (LinkNotFound $exception) {
            return response()->json(['message' => $exception->getMessage()], 404);
        }

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
     * @param LinkViewFactoryInterface $factory
     * @return RedirectResponse
     */
    public function go(string $code,
                       Request $request,
                       LinkViewsRepositoryInterface $linkViewsRepository,
                       LinkViewFactoryInterface $factory): RedirectResponse
    {
        $link = $this->linksRepository->findByCode($code);
        $linkView = $factory->create($link->id,
            CarbonImmutable::now()->toDateTimeImmutable(),
            $request->ip(),
            $request->userAgent());

        $linkViewsRepository->storeView($linkView);
        return response()->redirectTo($link->long_url);
    }
}
