<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemoController extends AbstractController
{
    /**
     * Unix Time
     */
    #[Route(path: '/unixtime', name: 'unixtime')]
    public function unixtime()
    {
        $data = [
            'meta_robots' => 'index,follow',
            'meta_title' => 'Unix-Time',
            'meta_desc' => 'Die Unix-Time gibt die Anzahl der Sekunden seit dem 1.1.1970 00:00:00 UTC an.',
            'header' => 'Unix-Time',
            'message' => 'Die Unix-Time gibt die Anzahl der Sekunden seit dem 1.1.1970 00:00:00 UTC an.',
            'link' => 'https://de.wikipedia.org/wiki/Unixzeit',
        ];

        return $this->render('sites/unixtime.html.twig',
            ['data' => $data]);
    }

    /**
     * Week
     */
    #[Route(path: '/week', name: 'week')]
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
     */
    #[Route(path: '/checkdate', name: 'checkdate')]
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
     */
    #[Route(path: '/leapyear', name: 'leapyear')]
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
     */
    #[Route(path: '/co2', name: 'co2')]
    public function co2()
    {
        $data = [
            'meta_robots' => 'index,follow',
            'meta_title' => 'CO² im Jahr',
            'meta_desc' => '',
            'header' => 'C0² im Jahr',
            'message' => 'Durchschnittlicher Jahreswert für C0² in der Athmosphäre in PPM',
            'link' => 'https://gml.noaa.gov/ccgg/trends/data.html',
            'minyear' => 1959,
            'maxyear' => intval(date('Y')) -1,
            'defaultyear' => intval(date('Y')) -1,
        ];

        return $this->render('sites/co2.html.twig', ['data' => $data]);
    }

    /**
     * CO² reverse
     */
    #[Route(path: '/co2reverse', name: 'co2reverse')]
    public function co2reverse()
    {
        $data = [
            'meta_robots' => 'index,follow',
            'meta_title' => 'Jahr mit CO² Wert',
            'meta_desc' => '',
            'header' => 'Jahr mit CO² Wert',
            'message' => 'In welchem Jahr lag der C0² Anteil in der Athmosphäre auf dem angegebenen Wert',
            'link' => 'https://gml.noaa.gov/ccgg/trends/data.html',
            'defaultyear' => intval(date('Y')) -1,
        ];

        return $this->render('sites/co2reverse.html.twig', ['data' => $data]);
    }

    /**
     * Age
     */
    #[Route(path: '/age', name: 'age')]
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
     */
    #[Route(path: '/progress', name: 'progress')]
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
     * Gesetzliche Feiertage in Deutschland
     */
    #[Route(path: '/germanpublicholidays', name: 'germanpublicholidays')]
    public function germanpublicholidays()
    {
        $data = [
            'meta_robots' => 'index,follow',
            'meta_title' => 'Gesetzliche Feiertage in Deutschland',
            'meta_desc' => 'Eine Api für die gesetzlichen Feiertage in Deutschland und seinen Bundesländern.',
            'header' => 'Gesetzliche Feiertage in Deutschland',
            'message' => 'Eine Api für die gesetzlichen Feiertage in Deutschland und seinen Bundesländern.',
        ];

        return $this->render('sites/germanpublicholidays.html.twig', ['data' => $data]);
    }

}