<?php declare(strict_types=1);

namespace Mottor\Repository;

use Mottor\Model\Customer;
use Mottor\Randomizer;

class RandomCustomerRepository implements CustomerRepositoryInterface
{
    /**
     * @var Randomizer
     */
    private $randomizer;

    public function __construct(Randomizer $randomizer)
    {
        $this->randomizer = $randomizer;
    }

    public function getCustomer(): Customer
    {
        $customer = new Customer();
        $customer->setCountGoods($this->randomizer->getRandomInt(50, 100));

        return $customer;
    }
}