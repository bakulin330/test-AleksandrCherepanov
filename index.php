<?php

use Mottor\Collection\CustomersPerHourCollection;
use Mottor\Market;
use Mottor\Model\CustomerPerHour;
use Mottor\Model\MarketSettings;
use Mottor\Randomizer;
use Mottor\Reporter\StdoutReporterDeskCollection;
use Mottor\Repository\RandomCustomerRepository;
use Mottor\Timer;

require_once __DIR__ . '/vendor/autoload.php';

$customerPerHourCollection = new CustomersPerHourCollection();

foreach (range(0, 12) as $hour) {
    $customerPerHour = new CustomerPerHour();
    $customerPerHour->setHour($hour);
    $customerPerHour->setMaxCustomers((int)(100 / $hour + 1));
    $customerPerHourCollection->add($customerPerHour);
}


$marketSettings = new MarketSettings(5, 15, $customerPerHourCollection);
$marketSettings->setHourWithoutCustomer(12);

$timer = new Timer();
$reporter = new StdoutReporterDeskCollection();
$randomizer = new Randomizer();
$repository = new RandomCustomerRepository($randomizer);

$market = new Market($timer, $randomizer, $reporter, $marketSettings, $repository);
$market->open();