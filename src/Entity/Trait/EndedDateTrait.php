<?php

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

trait EndedDateTrait
{
    #[ORM\Column(type: 'datetime', nullable: true)]
    protected ?\DateTimeInterface $endedDate = null;

    /**
     * @return \DateTimeInterface|null
     */
    public function getEndedDate(): ?\DateTimeInterface
    {
        return $this->endedDate;
    }

    /**
     * @param \DateTimeInterface|null $endedDate
     *
     * @return $this
     */
    public function setEndedDate(?\DateTimeInterface $endedDate): self
    {
        $this->endedDate = $endedDate;

        return $this;
    }
}