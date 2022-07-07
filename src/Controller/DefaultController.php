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
            'meta_robots' => 'index,follow',
            'meta_title' => 'DigiDates.de - API für Datums- und Zeit-Funktionen',
            'meta_desc' => 'Kostenlose REST API für Datums- und Zeitfunktionen.',
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
            'meta_robots' => 'index,follow',
            'meta_title' => 'Kalenderwoche ermitteln',
            'meta_desc' => '',
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
            'meta_robots' => 'index,follow',
            'meta_title' => 'Prüfen ob ein Datum gültig ist',
            'meta_desc' => '',
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
            'meta_robots' => 'index,follow',
            'meta_title' => 'Ist es ein Schaltjahr oder nicht?',
            'meta_desc' => '',
            'header' => 'Schaltjahr',
            'message' => 'Ein Schaltjahr ist ein Jahr, das im Unterschied zum Gemeinjahr einen zusätzlichen Schalttag am 29.2. enthält.',
            'link' => 'https://de.wikipedia.org/wiki/Schaltjahr',
        ];

        return $this->render('sites/leapyear.html.twig', ['data' => $data]);
    }

    /**
     * CO²
     *
     * @Route("/co2", name="co2")
     */
    public function co2()
    {
        $data = [
            'meta_robots' => 'index,follow',
            'meta_title' => 'CO² im Jahr',
            'meta_desc' => '',
            'header' => 'C0² im Jahr',
            'message' => 'Durschnittlicher Jahreswert für C0² in der Athmosphäre in PPM',
            'link' => 'https://gml.noaa.gov/ccgg/trends/data.html',
            'minyear' => 1959,
            'maxyear' => intval(date('Y')) -1,
            'defaultyear' => intval(date('Y')) -1,
        ];

        return $this->render('sites/co2.html.twig', ['data' => $data]);
    }

    /**
     * Age
     *
     * @Route("/age", name="age")
     */
    public function age()
    {
        $data = [
            'meta_robots' => 'index,follow',
            'meta_title' => 'Das Alter ermitteln',
            'meta_desc' => '',
            'header' => 'Alter',
            'message' => 'Das Alter für ein gegebenes Datum ermitteln.',
        ];

        return $this->render('sites/age.html.twig', ['data' => $data]);
    }

    /**
     * Fortschritt
     *
     * @Route("/progress", name="progress")
     */
    public function progress()
    {
        $data = [
            'meta_robots' => 'index,follow',
            'meta_title' => 'Wie ist der Fortschritt',
            'meta_desc' => '',
            'header' => 'Fortschritt',
            'message' => 'Der aktuell vergangene Zeitraum von Anfang bis Ende in Prozent.',
            'defaultstartdate' => date('Y').'-01-01',
            'defaultenddate' => date('Y').'-12-31',
        ];

        return $this->render('sites/progress.html.twig', ['data' => $data]);
    }

    /**
     * Open API YAML file
     *
     * @Route("/docs/openapi.yaml", name="openapi.yaml")
     */
    public function openapiyaml()
    {
        $output = file_get_contents('../docs/openapi.yaml');
        $r = new Response($output);
        $r->headers->set('Content-Type', 'application/x-yaml');
        $r->headers->set('Access-Control-Allow-Origin', '*');
        return new Response($output);
    }

    /**
     * Datenschutz
     *
     * @Route("/datenschutz.html", name="datenschutz")
     */
    public function datenschutz()
    {
        $data = [
            'meta_robots' => 'noindex,follow',
            'meta_title' => 'Datenschutz',
            'meta_desc' => '',
        ];

        return $this->render('sites/datenschutz.html.twig', ['data' => $data]);
    }

    /**
     * Impressum
     *
     * @Route("/impressum.html", name="impressum")
     */
    public function impressum()
    {
        $data = [
            'meta_robots' => 'noindex,follow',
            'meta_title' => 'Impressum',
            'meta_desc' => '',
        ];

        return $this->render('sites/impressum.html.twig', ['data' => $data]);
    }
}