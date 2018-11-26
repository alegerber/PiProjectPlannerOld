<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DatabaseController extends AbstractController
{
    public function index()
    {

        return $this->render('database.html.twig');
    }
}