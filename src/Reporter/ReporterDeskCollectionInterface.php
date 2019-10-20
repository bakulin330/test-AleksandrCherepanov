<?php declare(strict_types=1);

namespace Mottor\Reporter;

use Mottor\Collection\DeskCollection;

interface ReporterDeskCollectionInterface
{
    public function report(DeskCollection $collection): void;
}
