<?php declare(strict_types=1);

namespace Mottor;

use Mottor\Collection\CustomerCollection;
use Mottor\Model\Customer;

class Desk
{
    private const MILLISECONDS_FOR_ONE_GOOD = 2;
    private const MILLISECONDS_FOR_PAYMENT = 300;
    private const MILLISECONDS_FOR_WAITING = 300;
    private const MAX_CUSTOMER_BEFORE_OVERFLOW = 4;

    private $openTime;
    private $opened;
    private $customers;
    private $serveDelta = 0;
    private $timer;
    private $deskId;

    public function __construct(Timer $timer, int $deskId)
    {
        $this->timer = $timer;
        $this->customers = new CustomerCollection();
        $this->deskId = $deskId;
        $this->opened = false;
    }

    public function addCustomer(Customer $customer): void
    {
        $this->customers->add($customer);
    }

    public function serveCustomer(): void
    {
        $timeOffset = $this->serveDelta + $this->openTime;
        $waitingTimeIsOver =
            $this->timer->getCurrentTimeInMilliseconds() >= $timeOffset + self::MILLISECONDS_FOR_WAITING;

        if ($waitingTimeIsOver && $this->customers->isEmpty()) {
            $this->close();
            return;
        }

        if ($this->customers->isEmpty()) {
            return;
        }

        /** @var Customer $servedCustomer */
        $servedCustomer = $this->customers->first();
        $serveTime = self::MILLISECONDS_FOR_PAYMENT + $servedCustomer->getCountGoods() * self::MILLISECONDS_FOR_ONE_GOOD;

        if ($this->timer->getCurrentTimeInMilliseconds() >= $serveTime + $timeOffset) {
            $this->customers->removeElement($servedCustomer);
            $this->serveDelta += $serveTime;
        }
    }

    public function getCustomersCount(): int
    {
        return $this->customers->count();
    }

    public function isOverflow(): bool
    {
        return $this->customers->count() > self::MAX_CUSTOMER_BEFORE_OVERFLOW;
    }

    public function isOpen(): bool
    {
        return $this->opened;
    }

    public function open(): void
    {
        $this->openTime = $this->timer->getCurrentTimeInMilliseconds();
        $this->opened = true;
    }

    public function getId(): int
    {
        return $this->deskId;
    }

    private function close(): void
    {
        if ($this->getCustomersCount() > 0) {
            return;
        }

        $this->serveDelta = 0;
        $this->opened = false;
    }
}
