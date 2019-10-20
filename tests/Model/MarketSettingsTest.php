<?php declare(strict_types=1);

namespace Tests\Model;

use Mottor\Collection\CustomersPerHourCollection;
use Mottor\Model\CustomerPerHour;
use Mottor\Model\MarketSettings;
use PHPUnit\Framework\TestCase;

class MarketSettingsTest extends TestCase
{
    public function dataSetGet(): array
    {
        return [
            'Case #1' => [
                [1, 2, 3, 4],
                [1, 2, 3, 4],
                [4, 5, 6, 8],
                [4, 5, 6, 8],
            ],
            'Case #2' => [
                [4, 5, 6, 8],
                [4, 5, 6, 8],
                [1, 2, 3, 4],
                [1, 2, 3, 4],
            ]
        ];
    }

    /**
     * @dataProvider  dataSetGet
     *
     * @param $init
     * @param $expected
     * @param $modify
     * @param $expectedModify
     */
    public function testSetGet($init, $expected, $modify, $expectedModify): void
    {
        $customerPerHourCollection = new CustomersPerHourCollection();
        foreach (range(1, $init[2]) as $hour) {
            $customerPerHour = new CustomerPerHour();
            $customerPerHour->setHour($hour);
            $customerPerHour->setMaxCustomers($hour);
            $customerPerHourCollection->add($customerPerHour);
        }


        $model = new MarketSettings($init[0], $init[1], $customerPerHourCollection);
        $model->setHourWithoutCustomer($init[3]);



        self::assertEquals($expected[0], $model->getDeskCount());
        self::assertEquals($expected[1], $model->getWorkingHoursCount());
        self::assertEquals($expected[2], $model->getMaxCustomerAllowed($init[2]));
        self::assertEquals($expected[3], $model->getHourWithoutCustomer());

        $customerPerHour = new CustomerPerHour();
        $customerPerHour->setHour($modify[2]);
        $customerPerHour->setMaxCustomers($modify[2]);

        $customerPerHourCollection->add($customerPerHour);

        $model->setDeskCount($modify[0]);
        $model->setWorkingHoursCount($modify[1]);
        $model->setCustomersPerHourCollection($customerPerHourCollection);
        $model->setHourWithoutCustomer($modify[3]);

        self::assertEquals($expectedModify[0], $model->getDeskCount());
        self::assertEquals($expectedModify[1], $model->getWorkingHoursCount());
        self::assertEquals($expectedModify[2], $model->getMaxCustomerAllowed($modify[2]));
        self::assertEquals($expectedModify[3], $model->getHourWithoutCustomer());
    }
}
