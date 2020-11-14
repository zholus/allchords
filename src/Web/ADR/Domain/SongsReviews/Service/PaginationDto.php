<?php
declare(strict_types=1);

namespace App\Web\ADR\Domain\SongsReviews\Service;

class PaginationDto
{
    private int $totalElementsCount;
    private int $currentPage;
    private int $totalPagesCount;
    private int $elementsOnPage;

    public function __construct(int $totalElementsCount, int $currentPage, int $totalPagesCount, int $elementsOnPage)
    {
        $this->totalElementsCount = $totalElementsCount;
        $this->currentPage = $currentPage;
        $this->totalPagesCount = $totalPagesCount;
        $this->elementsOnPage = $elementsOnPage;
    }

    public function getTotalElementsCount(): int
    {
        return $this->totalElementsCount;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getTotalPagesCount(): int
    {
        return $this->totalPagesCount;
    }

    public function getElementsOnPage(): int
    {
        return $this->elementsOnPage;
    }
}
