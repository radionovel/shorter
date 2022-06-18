<?php

namespace App\Repositories;

use App\Contracts\Repositories\LinksRepositoryInterface;
use App\DTO\CreateLinkDto;
use App\DTO\CreateLinksCollection;
use App\DTO\LinkDto;
use App\DTO\LinksCollection;
use App\Models\Link;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class LinksRepository implements LinksRepositoryInterface
{
    /**
     * @param int $id
     * @param array $attributes
     * @return void
     * @throws \Throwable
     */
    public function update(int $id, array $attributes)
    {
        /** @var Link $link */
        $link = Link::findOrFail($id);

        if (!empty($attributes['tags'])) {
            $tags = $this->storeTags($attributes['tags']);
            $link->tags()->sync($tags);
            unset($attributes['tags']);
        }

        $link->updateOrFail($attributes);
    }

    /**
     * @param int $id
     * @return LinkDto
     * @throws UnknownProperties
     */
    public function find(int $id)
    {
        /** @var Link $link */
        $link = Link::findOrFail($id);
        return $link->dto($this->parseTags($link->tags));
    }

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id)
    {
        Link::find($id)->delete();
    }

    /**
     * @param Collection $tags
     * @return array
     */
    private function parseTags(Collection $tags): array
    {
        return $tags->pluck('tag')->all();
    }

    /**
     * @param array $filter
     * @return Collection
     */
    public function list(array $filter): Collection
    {
        $links = Link::filter($filter)
            ->with('tags')
            ->get();
        $collection = new Collection();
        foreach ($links as $link) {
            $collection->add($link->dto($this->parseTags($link->tags)));
        }

        return $collection;
    }

    /**
     * @param array $linkTags
     * @return Collection
     */
    protected function storeTags(array $linkTags): Collection
    {
        $insert = array_map(function ($tag) {
            return ['tag' => $tag];
        }, $linkTags);

        Tag::query()->insertOrIgnore($insert);

        return Tag::query()
            ->whereIn('tag', $linkTags)
            ->get();
    }

    /**
     * @param CreateLinkDto $createLink
     * @return LinkDto
     * @throws UnknownProperties
     */
    public function storeLink(CreateLinkDto $createLink): LinkDto
    {
        $link = Link::create([
            'code' => Str::random(6),
            'link' => $createLink->long_url,
            'title' => $createLink->title,
        ]);

        $tags = $this->storeTags($createLink->tags);
        $link->tags()->sync($tags);

        return $link->dto($tags->pluck('tag')->all());
    }

    /**
     * @param CreateLinksCollection $createLinksCollection
     * @return LinksCollection
     * @throws UnknownProperties
     */
    public function storeCollection(CreateLinksCollection $createLinksCollection): LinksCollection
    {
        $links = [];
        foreach ($createLinksCollection as $link) {
            $links[] = $this->storeLink($link);
        }

        return new LinksCollection($links);
    }

}
