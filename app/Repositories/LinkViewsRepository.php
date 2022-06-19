<?php

namespace App\Repositories;

use App\Contracts\Repositories\LinkViewsRepositoryInterface;
use App\DTO\CreateLinkViewDto;
use App\DTO\LinkStatDto;
use App\DTO\LinkViewDto;
use App\DTO\TotalStatDto;
use App\Models\LinkView;
use Illuminate\Support\Collection;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class LinkViewsRepository implements LinkViewsRepositoryInterface
{
    /**
     * @param CreateLinkViewDto $link
     * @return LinkViewDto
     * @throws UnknownProperties
     */
    public function storeView(CreateLinkViewDto $link): LinkViewDto
    {
        $view = LinkView::create($link->toArray());
        return $view->dto();
    }

    /**
     * @param array $filter
     * @return TotalStatDto
     * @throws UnknownProperties
     */
    public function totalStats(array $filter): TotalStatDto
    {
        $totalStats = LinkView::filter()
            ->selectRaw('COUNT(id) as total_views, COUNT(DISTINCT user_id) as unique_views')
            ->toBase()
            ->first();

        if (!is_null($totalStats)) {
            return new TotalStatDto([
                'total_views' => $totalStats->total_views,
                'unique_views' => $totalStats->unique_views,
            ]);
        }

        return new TotalStatDto();
    }

    /**
     * @param int $linkId
     * @return Collection
     */
    public function linkStats(int $linkId): Collection
    {
        return LinkView::query()
            ->selectRaw('user_id, view_date as date, COUNT(id) as total_views, COUNT(DISTINCT user_id) as unique_views')
            ->where('link_id', '=', $linkId)
            ->groupByRaw('1, 2')
            ->orderBy('date', 'desc')
            ->toBase()
            ->get()
            ->map(function ($view) {
                return new LinkStatDto([
                    'date' => $view->date,
                    'total_views' => $view->total_views,
                    'unique_views' => $view->unique_views,
                ]);
            });
    }

}
