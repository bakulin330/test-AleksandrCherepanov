<?php declare(strict_types=1);

namespace Mottor\Repository;

use Mottor\Model\Customer;

interface CustomerRepositoryInterface
{
    public function getCustomer(): Customer;
}