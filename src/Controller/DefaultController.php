<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * Index
     * @Route("/", name="index")
     */
    public function index()
    {
        $message = 'digidatesAPI';

        return new Response($message);
    }



}