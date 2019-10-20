<?php declare(strict_types=1);

namespace Mottor\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use Mottor\Model\CustomerPerHour;

class CustomersPerHourCollection extends ArrayCollection
{
    public function getCustomerAllowedByHour(int $hour): int
    {
        /** @var CustomerPerHour $customerPerHour */
        foreach ($this->getIterator() as $customerPerHour) {
            if ($customerPerHour->getHour() === $hour) {
                return $customerPerHour->getMaxCustomers();
            }
        }

        return 0;
    }
}