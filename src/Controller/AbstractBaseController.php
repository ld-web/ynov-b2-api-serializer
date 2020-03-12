<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;

abstract class AbstractBaseController extends AbstractController
{
  protected function getFormErrors(FormInterface $form): array
  {
    $errors = [];
    // Récupère toutes les erreurs du formulaire
    // Et toutes les erreurs des champs déclarés dans le formulaire
    // Ces erreurs seront récupérées sous forme d'objet
    $formErrors = $form->getErrors(true);

    // Donc on va mapper chaque erreur dans un tableau
    foreach ($formErrors as $error) {
      $field = $error->getOrigin()->getName();
      $message = $error->getMessage();

      // Pour retourner une réponse compréhensible à notre client,
      // On formate notre tableau de la manière suivante :
      // Clé => nom du champ où il y a un problème
      // Message => Message d'erreur associé
      $errors[$field] = $message;
    }

    return $errors;
  }
}
