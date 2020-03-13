<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class CarController extends AbstractBaseController
{
  // Injection de dépendace par constructeur
  private $em;

  public function __construct(EntityManagerInterface $em)
  {
    $this->em = $em;
  }
  
  /**
   * @Route("/car", name="car_list", methods={"GET"})
   */
  public function list(
    CarRepository $carRepository,
    SerializerInterface $serializer
  ) {
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

  /**
   * @Route("/car/{id}", name="car_detail", methods={"GET"})
   */
  public function detail(Car $car)
  {
    return $this->json([
      'car' => $car
    ]);
  }

  /**
   * @Route("/car", name="car_create", methods={"POST"})
   */
  public function create(
    Request $request
  ) {
    $data = json_decode($request->getContent(), true);
    $car = new Car();
    $form = $this->createForm(CarType::class, $car);

    // handleRequest ne va pas mapper les champs envoyés dans le corps de la requête. On ne va donc pas l'utiliser ici
    // $form->handleRequest($request);

    $form->submit($data);

    if ($form->isSubmitted() && $form->isValid()) {
      // On pourrait renseigner la date de création à ce niveau
      // Mais si on a besoin de créer une voiture ailleurs que dans ce contrôleur,
      // alors il faudra penser à renseigner la date de création.
      // On rique donc :
      // - d'oublier de renseigner cette date
      // - et, si on y pense, tout simplement de dupliquer notre code
      // $car->setCreated(new DateTime());
      $this->em->persist($car);
      $this->em->flush();

      return $this->json(
        $car,
        Response::HTTP_CREATED,
        [],
        ["groups" => "car:create"]
      );

      // Equivalent, mais en ignorant 2 attributs
      // au lieu d'en inclure plusieurs dans un groupe
      // return $this->json(
      //   $car,
      //   Response::HTTP_CREATED,
      //   [],
      //   [AbstractNormalizer::IGNORED_ATTRIBUTES => ["created", "visible"]]
      // );
    }

    // Si on est pas passé dans le if,
    // Alors notre formulaire est invalide
    // On récupère donc les erreurs à l'aide de notre méthode
    // Et on la renvoie au client
    $errors = $this->getFormErrors($form);
    return $this->json(
      $errors,
      Response::HTTP_BAD_REQUEST
    );
  }

  /**
   * @Route("/car/{id}", name="car_patch", methods={"PATCH"})
   */
  public function patch(Car $car, Request $request)
  {
    return $this->update($request, $car, false);
  }

  /**
   * @Route("/car/{id}", name="car_put", methods={"PUT"})
   */
  public function put(Car $car, Request $request)
  {
    return $this->update($request, $car);
  }

  /**
   * @Route("/car/{id}", name="car_delete", methods={"DELETE"})
   */
  public function delete(Car $car)
  {
    $this->em->remove($car);
    $this->em->flush();

    return $this->json('ok');
  }

  private function update(
    Request $request,
    Car $car,
    bool $clearMissing = true
  ) {
    $data = json_decode($request->getContent(), true);
    $form = $this->createForm(CarType::class, $car);

    $form->submit($data, $clearMissing);

    if ($form->isSubmitted() && $form->isValid()) {
      $this->em->flush();

      return $this->json($car);
    }

    $errors = $this->getFormErrors($form);
    return $this->json(
      $errors,
      Response::HTTP_BAD_REQUEST
    );
  }
}
