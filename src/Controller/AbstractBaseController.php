<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;

abstract class AbstractBaseController extends AbstractController
{
  protected function getFormErrors(FormInterface $form): array
  {
    $errors = [];
    $formErrors = $form->getErrors(true);

    foreach ($formErrors as $error) {
      $field = $error->getOrigin()->getName();
      $message = $error->getMessage();

      $errors[$field] = $message;
    }

    return $errors;
  }
}
