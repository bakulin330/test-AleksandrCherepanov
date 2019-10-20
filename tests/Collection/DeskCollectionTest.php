<?php declare(strict_types=1);

namespace Tests\Collection;

use Mottor\Collection\DeskCollection;
use Mottor\Desk;
use Mottor\Model\Customer;
use Mottor\Timer;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DeskCollectionTest extends TestCase
{
    /** @var DeskCollection */
    private $collection;

    public function setUp(): void
    {
        $this->collection = new DeskCollection();
    }

    public function dataGetDeskForServe(): array
    {
        return [
            'Case #1. Return vacant desk' => [
                [13, 7, 3, 5, 6],
                2
            ],
            'Case #2. Return desk with minimal count of customers' => [
                [13, 20, 12, 7, 17],
                3
            ]
        ];
    }

    /**
     * @dataProvider dataGetDeskForServe
     *
     * @param $count
     * @param $expected
     */
    public function testGetDeskForServe($count, $expected): void
    {
        foreach ($count as $key => $value) {
            $desk = new Desk($this->getMock(Timer::class), $key);
            $desk->open();
            foreach (range(0, $value) as $i) {
                $customer = new Customer();
                $desk->addCustomer($customer);
            }

            $this->collection->add($desk);
        }

        self::assertEquals($expected, $this->collection->getDeskForServe()->getId());
    }

    public function dataGetCustomersCount(): array
    {
        return [
            'Case #1' => [
                [10, 5, 7],
                22
            ],
            'Case #2' => [
                [16, 30, 40, 12, 20],
                118
            ]
        ];
    }

    /**
     * @dataProvider dataGetCustomersCount
     *
     * @param $count
     * @param $expected
     */
    public function testGetCustomersCount($count, $expected): void
    {
        foreach ($count as $key => $value) {
            $varName = "desk$key";
            $$varName = $this->getMock(Desk::class);
            $$varName->expects($this->once())->method('getCustomersCount')->willReturn($value);
            $this->collection->add($$varName);
        }

        self::assertEquals($expected, $this->collection->getCustomersCount());
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
