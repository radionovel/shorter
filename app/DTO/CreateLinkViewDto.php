<?php
declare(strict_types=1);

namespace App\DTO;

class CreateLinkViewDto
{

    public function __construct(private int                $linkId,
                                private string             $userId,
                                private \DateTimeImmutable $viewDate,
                                private string             $userIp,
                                private string             $userAgent)
    {
    }

    /**
     * @return int
     */
    public function getLinkId(): int
    {
        return $this->linkId;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getViewDate(): \DateTimeImmutable
    {
        return $this->viewDate;
    }

    /**
     * @return string
     */
    public function getUserIp(): string
    {
        return $this->userIp;
    }

    /**
     * @return string
     */
    public function getUserAgent(): string
    {
        return $this->userAgent;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'link_id' => $this->linkId,
            'user_id' => $this->userId,
            'view_date' => $this->viewDate,
            'user_ip' => $this->userIp,
            'user_agent' => $this->userAgent,
        ];
    }
}
