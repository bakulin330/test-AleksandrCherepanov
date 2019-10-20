<?php declare(strict_types=1);

namespace Tests\Reporter;

use Mottor\Collection\DeskCollection;
use Mottor\Desk;
use Mottor\Reporter\ReporterDeskCollectionInterface;
use Mottor\Reporter\StdoutReporterDeskCollection;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class StdoutReporterDeskCollectionTest extends TestCase
{
    /** @var ReporterDeskCollectionInterface */
    private $reporter;

    public function setUp(): void
    {
        $this->reporter = new StdoutReporterDeskCollection();
    }

    public function testReport(): void
    {
        /** @var MockObject | DeskCollection $deskCollection */
        $deskCollection = $this->getMock(DeskCollection::class, ['getCustomersCount', 'getCountOpened']);

        $desk1 = $this->getMock(Desk::class);
        $desk2 = $this->getMock(Desk::class);
        $desk3 = $this->getMock(Desk::class);

        $desk1->expects($this->once())->method('getId')->willReturn(1);
        $desk1->expects($this->once())->method('isOpen')->willReturn(true);
        $desk1->expects($this->once())->method('getCustomersCount')->willReturn(7);

        $desk2->expects($this->once())->method('getId')->willReturn(2);
        $desk2->expects($this->once())->method('isOpen')->willReturn(false);
        $desk2->expects($this->once())->method('getCustomersCount')->willReturn(0);

        $desk3->expects($this->once())->method('getId')->willReturn(3);
        $desk3->expects($this->once())->method('isOpen')->willReturn(true);
        $desk3->expects($this->once())->method('getCustomersCount')->willReturn(5);

        $deskCollection->expects($this->once())->method('getCustomersCount')->willReturn(12);
        $deskCollection->expects($this->once())->method('getCountOpened')->willReturn(2);

        $deskCollection->add($desk1);
        $deskCollection->add($desk2);
        $deskCollection->add($desk3);

        $this->expectOutputString("All customers count: 12\nAll opened desks: 2\nDesk #1 customers count: 7. Desk #1: Opened.\nDesk #2 customers count: 0. Desk #2: Closed.\nDesk #3 customers count: 5. Desk #3: Opened.\n\n\n");

        $this->reporter->report($deskCollection);
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
