<?php declare(strict_types=1);

namespace Mottor;

use Mottor\Collection\DeskCollection;
use Mottor\Model\MarketSettings;
use Mottor\Reporter\ReporterDeskCollectionInterface;
use Mottor\Repository\CustomerRepositoryInterface;

class Market
{
    private $timer;
    private $reporter;
    private $marketSettings;
    private $deskCollection;
    private $randomizer;
    private $customerRepository;

    private $openTime;
    private $timeOffset = 0;

    public function __construct(
        Timer $timer,
        Randomizer $randomizer,
        ReporterDeskCollectionInterface $reporter,
        MarketSettings $marketSettings,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->timer = $timer;
        $this->reporter = $reporter;
        $this->marketSettings = $marketSettings;
        $this->deskCollection = new DeskCollection();
        $this->randomizer = $randomizer;
        $this->customerRepository = $customerRepository;
    }

    public function open(): void
    {
        echo "Mottor market is opened...\n";
        $this->openTime = $this->timer->getCurrentTimeInMilliseconds();

        foreach (range(1, $this->marketSettings->getDeskCount()) as $i) {
            $this->deskCollection->add(new Desk($this->timer, $i));
        }

        $this->reporter->report($this->deskCollection);

        while ($this->isOpened()) {
            $this->enterInStore();
            $this->serve();
            $this->report();
        }

        $this->close();
    }

    private function enterInStore(): void
    {
        $timePassedFromOpening = $this->getTimePassedFromOpening();

        if ($timePassedFromOpening < $this->randomizer->getRandomInt(3000, 3600) + $this->timeOffset) {
            return;
        }

        $customersPerHour = $this->marketSettings->getMaxCustomerAllowed(
            (int)ceil($timePassedFromOpening / $this->timer->getSecondsInHour())
        );

        if ($this->deskCollection->getCustomersCount() >= $customersPerHour) {
            return;
        }

        $timeWithoutCustomers = $this->timer->getSecondsInHour() * $this->marketSettings->getHourWithoutCustomer();

        $customersCount = $this->randomizer->getRandomInt(1, 3);
        if ($customersCount > 2 || $timePassedFromOpening > $timeWithoutCustomers) {
            return;
        }

        for ($i = 1; $i < $customersCount; $i++) {
            $desk = $this->deskCollection->getDeskForServe();
            if (!$desk->isOpen()) {
                $desk->open();
            }

            $desk->addCustomer($this->customerRepository->getCustomer());
        }
    }

    private function serve(): void
    {
        /** @var Desk $desk */
        foreach ($this->deskCollection->getIterator() as $desk) {
            $desk->serveCustomer();
        }
    }

    private function close(): void
    {
        echo "Mottor market was closed...\n\n";
    }

    private function isOpened(): bool
    {
        $workingHoursInSeconds = $this->timer->getHoursInSeconds($this->marketSettings->getWorkingHoursCount());
        return $this->getTimePassedFromOpening() < $workingHoursInSeconds;
    }

    private function report(): void
    {
        $timePassedFromOpening = $this->getTimePassedFromOpening();
        $offsetInSecondsFromOpening = $this->timer->getSecondsInHour() + $this->timeOffset;

        if ($timePassedFromOpening > $offsetInSecondsFromOpening) {
            $this->reporter->report($this->deskCollection);
            $this->timeOffset += $this->timer->getSecondsInHour();
        }
    }

    private function getTimePassedFromOpening(): int
    {
        return $this->timer->getCurrentTimeInMilliseconds() - $this->openTime;
    }
}
