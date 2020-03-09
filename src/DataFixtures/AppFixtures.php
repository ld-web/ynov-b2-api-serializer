<?php

namespace App\DataFixtures;

use App\Car\Transmission;
use App\Entity\Car;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
  public function load(ObjectManager $manager)
  {
    $faker = Faker\Factory::create('fr_FR');
    $faker->addProvider(new Faker\Provider\Fakecar($faker));

    for ($i = 0; $i < 50; $i++) {
      $car = new Car();

      $car->setName($faker->vehicle)
        ->setKilometers($faker->numberBetween(2000, 250000))
        ->setReleaseYear($faker->numberBetween(1935, 1990))
        ->setVisible($faker->boolean(80))
        ->setTransmission(
          $faker->numberBetween(Transmission::AUTO, Transmission::HYBRID)
      );

      $manager->persist($car);
    }

    $manager->flush();
  }
}
