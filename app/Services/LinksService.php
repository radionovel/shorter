<?php
declare(strict_types=1);

namespace App\Services;

use App\Contracts\Repositories\LinksRepositoryInterface;
use App\Contracts\Services\LinksServiceInterface;
use App\DTO\CreateLinkDto;
use App\DTO\LinksCollection;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;

class LinksService implements LinksServiceInterface
{

    /**
     * @param Client $httpClient
     * @param LinksRepositoryInterface $linksRepository
     */
    public function __construct(protected Client $httpClient, protected LinksRepositoryInterface $linksRepository)
    {
    }

    /**
     * @param array<CreateLinkDto> $createLinksCollection
     * @return LinksCollection|false
     * @throws GuzzleException
     */
    public function storeCollection(array $createLinksCollection): array|bool
    {
        if ($this->canStoreLinkCollection($createLinksCollection)) {
            return $this->linksRepository->storeCollection($createLinksCollection);
        }

        return false;
    }

    /**
     * @param array<CreateLinkDto> $createLinksCollection
     * @return bool
     * @throws GuzzleException
     */
    protected function canStoreLinkCollection(array $createLinksCollection): bool
    {
        foreach ($createLinksCollection as $link) {
            if (!$this->isCorrectUrl($link->getLongUrl())) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string $url
     * @return bool
     * @throws GuzzleException
     */
    protected function isCorrectUrl(string $url): bool
    {
        try {
            $this->httpClient->get($url);
        } catch (ClientException $_) {
            return false;
        }

        return true;
    }
}
