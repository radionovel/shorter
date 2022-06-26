<?php

namespace App\Contracts\Repositories;

use App\DTO\CreateLinkDto;
use App\DTO\LinkDto;
use App\Exceptions\LinkNotFound;

interface LinksRepositoryInterface
{
    public function storeLink(CreateLinkDto $createLink): LinkDto;

    /**
     * @param array<CreateLinkDto> $createLinksCollection
     * @return array
     */
    public function storeCollection(array $createLinksCollection): array;

    public function list(array $filter);

    public function delete(int $id);

    /**
     * @param int $id
     * @return LinkDto
     *
     * @throws LinkNotFound
     */
    public function find(int $id): LinkDto;

    public function findByCode(string $code): LinkDto;

    /**
     * @param int $id
     * @param array $attributes
     * @return mixed
     *
     * @throws LinkNotFound
     */
    public function update(int $id, array $attributes);
}
