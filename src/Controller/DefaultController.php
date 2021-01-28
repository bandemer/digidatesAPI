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

    /**
     * Week
     * @Route("/week", name="week")
     */
    public function week()
    {
        $message = 'Kalenderwoche ermitteln';

        return $this->render('sites/week.html.twig', ['message' => $message]);
    }


    /**
     * Fortschritt
     *
     * @Route("/progress", name="progress")
     */
    public function progress()
    {
        $message = 'Fortschritt';

        return $this->render('sites/progress.html.twig', ['message' => $message]);
    }




}