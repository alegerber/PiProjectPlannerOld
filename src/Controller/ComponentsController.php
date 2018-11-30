<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Button;

class ComponentsController extends AbstractController
{
    public function index()
    {
        $containers[][][][] = null;

        /* testdata */
        $containers[0]['content'][0]['text'] = 'test-cat';
        $containers[0]['content'][0]['link'] = 'components/test-cat';
        $containers[0]['title'] = 'Categories';
        $containers[1]['content'][0]['text'] = 'test-cat';
        $containers[1]['content'][0]['link'] = 'components/test-cat';
        $containers[1]['title'] = 'Tags';

        return $this->render('05-pages/components.html.twig',
        array('containers' => $containers)
        );
    }
}