<?php

namespace App\Contracts\Repositories;

use App\DTO\CreateLinkDto;
use App\DTO\CreateLinksCollection;
use App\DTO\LinkDto;
use App\DTO\LinksCollection;

interface LinksRepositoryInterface
{
    public function storeLink(CreateLinkDto $createLink): LinkDto;
    public function storeCollection(CreateLinksCollection $createLinksCollection): LinksCollection;
    public function list(array $filter);
    public function delete(int $id);
    public function find(int $id);
    public function update(int $id, array $attributes);
}
