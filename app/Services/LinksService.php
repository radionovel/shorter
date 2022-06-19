<?php

namespace App\Services;

use App\Contracts\Repositories\LinksRepositoryInterface;
use App\Contracts\Services\LinksServiceInterface;
use App\DTO\CreateLinkDto;
use App\DTO\CreateLinksCollection;
use App\DTO\LinksCollection;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;

class LinksService implements LinksServiceInterface
{

    protected Client $httpClient;
    protected LinksRepositoryInterface $linksRepository;

    /**
     * @param Client $httpClient
     * @param LinksRepositoryInterface $linksRepository
     */
    public function __construct(Client $httpClient, LinksRepositoryInterface $linksRepository)
    {
        $this->httpClient = $httpClient;
        $this->linksRepository = $linksRepository;
    }

    /**
     * @param CreateLinksCollection $createLinksCollection
     * @return LinksCollection|false
     * @throws GuzzleException
     */
    public function storeCollection(CreateLinksCollection $createLinksCollection): LinksCollection|bool
    {
        if ($this->canStoreLinkCollection($createLinksCollection)) {
            return $this->linksRepository->storeCollection($createLinksCollection);
        }

        return false;
    }

    /**
     * @param CreateLinksCollection $createLinksCollection
     * @return bool
     * @throws GuzzleException
     */
    protected function canStoreLinkCollection(CreateLinksCollection $createLinksCollection): bool
    {
        foreach ($createLinksCollection as $link) {
            /** @var CreateLinkDto $link */
            if (!$this->isCorrectUrl($link->long_url)) {
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
