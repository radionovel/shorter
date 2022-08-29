<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\LinksRepositoryInterface;
use App\DTO\CreateLinkDto;
use App\DTO\LinkDto;
use App\Exceptions\LinkNotFound;
use App\Models\Link;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Throwable;

class LinksRepository implements LinksRepositoryInterface
{
    /**
     * @param int $id
     * @param array $attributes
     * @return void
     * @throws Throwable
     */
    public function update(int $id, array $attributes)
    {
        if (null === $link = Link::find($id)) {
            throw new LinkNotFound();
        }

        if (!empty($attributes['tags'])) {
            $tags = $this->storeTags($attributes['tags']);
            $link->tags()->sync($tags);
            unset($attributes['tags']);
        }

        $link->updateOrFail($attributes);
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
     * @param int $id
     * @return LinkDto
     * @throws UnknownProperties|LinkNotFound
     */
    public function find(int $id): LinkDto
    {
        if (null === $link = Link::find($id)) {
            throw new LinkNotFound();
        }

        return $link->dto($this->parseTags($link->tags));
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
     * @param string $code
     * @return LinkDto
     * @throws UnknownProperties
     */
    public function findByCode(string $code): LinkDto
    {
        /** @var Link $link */
        $link = Link::query()
            ->where('code', '=', $code)
            ->firstOrFail();
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
     * @param array $filter
     * @return Collection
     */
    public function list(array $filter): Collection
    {
        $links = Link::filter($filter)
            ->with('tags')
            ->paginateFilter();
        $collection = new Collection();
        foreach ($links as $link) {
            $collection->add($link->dto($this->parseTags($link->tags)));
        }

        return $collection;
    }

    /**
     * @param array<CreateLinkDto> $createLinksCollection
     * @return array<LinkDto>
     * @throws UnknownProperties
     */
    public function storeCollection(array $createLinksCollection): array
    {
        return array_map(function ($link) {
            return $this->storeLink($link);
        }, $createLinksCollection);
    }

    /**
     * @param CreateLinkDto $createLink
     * @return LinkDto
     * @throws UnknownProperties
     */
    public function storeLink(CreateLinkDto $createLink): LinkDto
    {
        $link = Link::create([
            'status' => 'pending',
            'code' => Str::random(6),
            'link' => $createLink->getLongUrl(),
            'title' => $createLink->getTitle(),
        ]);

        $tags = $this->storeTags($createLink->getTags());
        $link->tags()->sync($tags);

        return $link->dto($tags->pluck('tag')->all());
    }

    /**
     * @throws LinkNotFound
     */
    public function setActive(int $linkId)
    {
        if(null === $link = Link::find($linkId)) {
            throw new LinkNotFound();
        }

        $link->update(['status' => 'active']);
    }

    /**
     * @throws LinkNotFound
     */
    public function setError(int $linkId)
    {
        if(null === $link = Link::find($linkId)) {
            throw new LinkNotFound();
        }

        $link->update(['status' => 'error']);
    }

}
