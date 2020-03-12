<?php

namespace App\Car;

class Transmission
{
  const AUTO = 1;
  const MANUAL = 2;
  const HYBRID = 3;
  const TURFU = 4;

  public static function getTransmissions(): array
  {
    return [
      self::AUTO,
      self::MANUAL,
      self::HYBRID,
      self::TURFU
    ];
  }
}
