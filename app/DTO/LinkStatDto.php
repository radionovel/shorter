<?php
declare(strict_types=1);

namespace App\DTO;

class LinkStatDto implements \JsonSerializable
{
    /**
     * @param int $totalViews
     * @param int $uniqueViews
     * @param \DateTimeImmutable $date
     */
    public function __construct(private int $totalViews, private int $uniqueViews, private \DateTimeImmutable $date)
    {
    }

    /**
     * @return int
     */
    public function getTotalViews(): int
    {
        return $this->totalViews;
    }

    /**
     * @return int
     */
    public function getUniqueViews(): int
    {
        return $this->uniqueViews;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'total_views' => $this->totalViews,
            'unique_views' => $this->uniqueViews,
            'date' => $this->date->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

}
