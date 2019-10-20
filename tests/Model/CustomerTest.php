<?php declare(strict_types=1);

namespace Tests\Model;

use Mottor\Model\Customer;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    /** @var Customer */
    private $model;

    public function setUp(): void
    {
        $this->model = new Customer();
    }

    public function dataSetGet(): array
    {
        return [
            'Case #1' => [
                10,
                10
            ],
            'Case #2' => [
                12,
                12
            ]
        ];
    }

    /**
     * @dataProvider dataSetGet
     *
     * @param $count
     * @param $expected
     */
    public function testSetGet($count, $expected): void
    {
        $this->model->setCountGoods($count);
        self::assertEquals($expected, $this->model->getCountGoods());
    }
}
