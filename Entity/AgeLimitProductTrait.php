<?php

namespace Plugin\AgeLimit\Entity;

use Doctrine\ORM\Mapping as ORM;
use Eccube\Annotation\EntityExtension;

/**
 * @EntityExtension("Eccube\Entity\Product")
 */
trait AgeLimitProductTrait
{
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $age_limit;

    /**
     * @return int
     */
    public function getAgeLimit()
    {
        return $this->age_limit;
    }

    /**
     * @param int $age_limit
     *
     * @return $this;
     */
    public function setAgeLimit($age_limit)
    {
        $this->age_limit = $age_limit;

        return $this;
    }
}