<?php

namespace App\Entity;

trait CreatedTrait
{
  /**
   * @ORM\Column(type="datetime")
   */
  private $created;
  
  public function getCreated(): ?\DateTimeInterface
  {
    return $this->created;
  }

  public function setCreated(\DateTimeInterface $created): self
  {
    $this->created = $created;

    return $this;
  }
}
