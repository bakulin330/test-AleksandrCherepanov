<?php declare(strict_types=1);

namespace Mottor\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use Mottor\Desk;

class DeskCollection extends ArrayCollection
{
    public function getDeskForServe(): Desk
    {
        /** @var Desk $deskForServe */
        $deskForServe = $this->getNotOverflowedDesk();

        if ($deskForServe !== null) {
            return $deskForServe;
        }

        $deskForServe = $this->first();

        /** @var Desk $desk */
        foreach ($this->getIterator() as $desk) {
            if ($desk->getCustomersCount() < $deskForServe->getCustomersCount()) {
                $deskForServe = $desk;
            }
        }

        return $deskForServe;
    }

    public function getCustomersCount(): int
    {
        $count = 0;
        /** @var Desk $desk */
        foreach ($this->getIterator() as $desk) {
            $count += $desk->getCustomersCount();
        }

        return $count;
    }

    private function getNotOverflowedDesk(): ?Desk
    {
        /** @var Desk $desk */
        foreach ($this->getIterator() as $desk) {
            if (!$desk->isOverflow() && $desk->isOpen()) {
                return $desk;
            }
        }

        return null;
    }

    public function getCountOpened(): int
    {
        $openedCollection = $this->filter(function (Desk $desk) {
            return $desk->isOpen();
        });

        return $openedCollection->count();
    }
}
