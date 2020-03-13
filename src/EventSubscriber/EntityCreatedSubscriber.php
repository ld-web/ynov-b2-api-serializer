<?php

namespace App\EventSubscriber;

use App\Entity\Car;
use App\Entity\Color;
use DateTime;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class EntityCreatedSubscriber implements EventSubscriber
{
  public function getSubscribedEvents()
  {
    return [
      Events::prePersist
    ];
  }

  public function prePersist(LifecycleEventArgs $args)
  {
    $object = $args->getObject();

    if ($object instanceof Car || $object instanceof Color) {
      $object->setCreated(new DateTime());
    }
  }
}
