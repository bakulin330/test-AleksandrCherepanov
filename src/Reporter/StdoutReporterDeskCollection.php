<?php declare(strict_types=1);

namespace Mottor\Reporter;

use Mottor\Collection\DeskCollection;
use Mottor\Desk;

class StdoutReporterDeskCollection implements ReporterDeskCollectionInterface
{
    private const DESK_IS_OPENED = 'Opened';
    private const DESK_IS_CLOSED = 'Closed';

    public function report(DeskCollection $collection): void
    {
        echo "All customers count: {$collection->getCustomersCount()}\n";
        echo "All opened desks: {$collection->getCountOpened()}\n";

        /** @var Desk $desk */
        foreach ($collection as $desk) {
            $deskId = "Desk #{$desk->getId()}";
            $deskStatus = $desk->isOpen() ? self::DESK_IS_OPENED : self::DESK_IS_CLOSED;

            echo "$deskId customers count: {$desk->getCustomersCount()}. $deskId: $deskStatus.\n";
        }

        echo "\n\n";
    }
}
