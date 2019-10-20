<?php declare(strict_types=1);

namespace Mottor\Model;

use Mottor\Collection\CustomersPerHourCollection;

class MarketSettings
{
    /** @var int */
    private $deskCount;
    /** @var int */
    private $workingHoursCount;
    /** @var CustomersPerHourCollection */
    private $customerPerHourCollection;
    /** @var int */
    private $hourWithoutCustomer;

    public function __construct(int $deskCount, int $workingHoursCount, CustomersPerHourCollection $customerPerHourCollection)
    {
        $this->deskCount = $deskCount;
        $this->workingHoursCount = $workingHoursCount;
        $this->customerPerHourCollection = $customerPerHourCollection;
    }
    
    /**
     * @return int
     */
    public function getDeskCount(): int
    {
        return $this->deskCount;
    }

    /**
     * @param int $deskCount
     */
    public function setDeskCount(int $deskCount): void
    {
        $this->deskCount = $deskCount;
    }

    /**
     * @return int
     */
    public function getWorkingHoursCount(): int
    {
        return $this->workingHoursCount;
    }

    /**
     * @param int $workingHoursCount
     */
    public function setWorkingHoursCount(int $workingHoursCount): void
    {
        $this->workingHoursCount = $workingHoursCount;
    }

    /**
     * @param int $hour
     *
     * @return int
     */
    public function getMaxCustomerAllowed(int $hour): int
    {
        return $this->customerPerHourCollection->getCustomerAllowedByHour($hour);
    }

    /**
     * @param CustomersPerHourCollection $customerPerHourCollection
     */
    public function setCustomersPerHourCollection(CustomersPerHourCollection $customerPerHourCollection): void
    {
        $this->customerPerHourCollection = $customerPerHourCollection;
    }

    /**
     * @return int
     */
    public function getHourWithoutCustomer(): int
    {
        return $this->hourWithoutCustomer;
    }

    /**
     * @param int $hourWithoutCustomer
     */
    public function setHourWithoutCustomer(int $hourWithoutCustomer): void
    {
        $this->hourWithoutCustomer = $hourWithoutCustomer;
    }
}
