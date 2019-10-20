<?php declare(strict_types=1);

namespace Mottor\Model;

class Customer
{
    private $countGoods;

    /**
     * @return mixed
     */
    public function getCountGoods()
    {
        return $this->countGoods;
    }

    /**
     * @param mixed $countGoods
     */
    public function setCountGoods($countGoods): void
    {
        $this->countGoods = $countGoods;
    }
}