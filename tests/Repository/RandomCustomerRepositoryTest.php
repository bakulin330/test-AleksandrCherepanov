<?php declare(strict_types=1);

namespace Tests\Repository;

use Mottor\Model\Customer;
use Mottor\Randomizer;
use Mottor\Repository\RandomCustomerRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class RandomCustomerRepositoryTest extends TestCase
{
    public function dataGetCustomer(): array
    {
        return [
            'Case #1' => [
                60
            ],
            'Case #2' => [
                70
            ]
        ];
    }

    /**
     * @dataProvider dataGetCustomer
     *
     * @param $count
     */
    public function testGetCustomer($count)
    {
        $randomzier = $this->getMock(Randomizer::class);
        $randomzier->expects($this->once())->method('getRandomInt')->with(50, 100)->willReturn($count);


        $repository = new RandomCustomerRepository($randomzier);
        $customer = $repository->getCustomer();

        self::assertInstanceOf(Customer::class, $customer);
        self::assertEquals($count, $customer->getCountGoods());
    }

    private function getMock(string $className, array $methods = []): MockObject
    {
        $builder = $this->getMockBuilder($className)->disableOriginalConstructor();
        if (!empty($methods)) {
            $builder = $builder->onlyMethods($methods);
        }

        return $builder->getMock();
    }
}
