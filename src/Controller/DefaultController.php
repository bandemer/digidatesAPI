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
        $data = [
            'header' => 'Unix-Time',
            'message' => 'Die Unix-Time gibt die Anzahl der Sekunden seit dem 1.1.1970 00:00:00 UTC an.',
            'link' => 'https://de.wikipedia.org/wiki/Unixzeit',
        ];

        return $this->render('sites/index.html.twig',
            ['data' => $data]);
    }

    /**
     * Week
     * @Route("/week", name="week")
     */
    public function week()
    {
        $data = [
            'header' => 'Kalenderwoche',
            'message' => 'Die Kalenderwoche definiert nach ISO 8601. KW1 eines Jahres ist diejenige, die den ersten Donnerstag enthält.',
            'link' => 'https://de.wikipedia.org/wiki/Woche#Z.C3.A4hlweise_nach_ISO_8601',
        ];

        return $this->render('sites/week.html.twig', ['data' => $data]);
    }

    /**
     * Prüfen ob valides Datum
     *
     * @Route("/checkdate", name="checkdate")
     */
    public function checkdate()
    {
        $data = [
            'header' => 'Gültiges Datum',
            'message' => 'Prüft, ob das angegebene Datum gültig ist.',
        ];

        return $this->render('sites/checkdate.html.twig', ['data' => $data]);
    }

    /**
     * Leapyear
     *
     * @Route("/leapyear", name="leapyear")
     */
    public function leapyear()
    {
        $data = [
            'header' => 'Schaltjahr',
            'message' => 'Ein Schaltjahr ist ein Jahr, das im Unterschied zum Gemeinjahr einen zusätzlichen Schalttag am 29.2. enthält.',
            'link' => 'https://de.wikipedia.org/wiki/Schaltjahr',
        ];

        return $this->render('sites/leapyear.html.twig', ['data' => $data]);
    }

    /**
     * Fortschritt
     *
     * @Route("/progress", name="progress")
     */
    public function progress()
    {
        $data = [
            'header' => 'Fortschritt',
            'message' => 'Der aktuell vergangene Zeitraum von Anfang bis Ende in Prozent.',
            'defaultstartdate' => date('Y').'-01-01',
            'defaultenddate' => date('Y').'-12-31',
        ];

        return $this->render('sites/progress.html.twig', ['data' => $data]);
    }

}