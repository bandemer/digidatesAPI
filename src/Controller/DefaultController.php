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
        $message = 'Willkommen bei DigiDates.de - Deinem API-Provider für Zeit und Datumsberechnungen.';

        return $this->render('sites/index.html.twig', ['message' => $message]);
    }



}