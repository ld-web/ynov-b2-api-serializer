<?php

namespace App\Controller;

use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CarController extends AbstractController
{
  /**
   * @Route("/car", name="car_list", methods={"GET"})
   */
  public function list(CarRepository $carRepository, SerializerInterface $serializer)
  {
    $cars = $carRepository->findAll();

    return $this->json([
      'cars' => $cars
    ]);

    // La méthode $this->json est une méthode "helper"
    // qui nous aide à sérialiser des variables en JSON.
    // Si le composant Serializer de Symfony n'est pas installé,
    // la méthode n'aura aucun moyen de normaliser + encoder les données.
    // En installant le composant Serializer, la méthode helper s'appuie dessus automatiquement pour générer le contenu au format JSON.
    // En fait, elle fait l'équivalent de ce qui suit :
    // $jsonCars = $serializer->serialize($cars, 'json');
    //
    // return new Response(
    //   $jsonCars,
    //   Response::HTTP_OK,
    //   ['Content-type' => 'application/json']
    // );
  }
}
