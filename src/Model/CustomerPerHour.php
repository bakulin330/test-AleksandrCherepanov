<?php declare(strict_types=1);

namespace Mottor\Model;

class CustomerPerHour
{
    /** @var int */
    private $hour;
    /** @var int */
    private $maxCustomers;

    /**
     * @return int
     */
    public function getHour(): int
    {
        return $this->hour;
    }

    /**
     * @param int $hour
     */
    public function setHour(int $hour): void
    {
        $this->hour = $hour;
    }

    /**
     * @return int
     */
    public function getMaxCustomers(): int
    {
        return $this->maxCustomers;
    }

    /**
     * @param int $maxCustomers
     */
    public function setMaxCustomers(int $maxCustomers): void
    {
        $this->maxCustomers = $maxCustomers;
    }
}
