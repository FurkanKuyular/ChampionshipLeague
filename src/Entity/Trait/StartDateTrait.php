<?php

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

trait StartDateTrait
{
    #[ORM\Column(type: 'datetime', nullable: true)]
    protected ?\DateTimeInterface $startDate = null;

    /**
     * @return \DateTimeInterface|null
     */
    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    /**
     * @param \DateTimeInterface|null $startDate
     *
     * @return $this
     */
    public function setStartDate(?\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }
}