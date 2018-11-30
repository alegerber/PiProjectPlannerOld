<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProjectsController extends AbstractController
{
    public function index()
    {
        $projects[][] = null;

        /* testdata */
        $projects[0]['link'] = 'projects/test0';
        $projects[0]['title'] = 'projects/test0';
        $projects[0]['description'] = 'projects/test0';
        $projects[1]['link'] = 'projects/test1';
        $projects[1]['title'] = 'projects/test1';
        $projects[1]['description'] = 'projects/test1';
        $projects[2]['link'] = 'projects/test2';
        $projects[2]['title'] = 'projects/test2';
        $projects[2]['description'] = 'projects/test2';

        return $this->render('05-pages/projects.html.twig',
        array('projects' => $projects)
        );
    }
}