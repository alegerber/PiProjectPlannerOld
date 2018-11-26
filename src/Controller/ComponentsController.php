<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ComponentsController extends AbstractController
{
    public function index()
    {

        return $this->render('components.html.twig');
    }
}