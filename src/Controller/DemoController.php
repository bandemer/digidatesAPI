<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class DemoController extends AbstractController
{
    /**
     * Unix Time
     */
    #[Route(path: '/unixtime', name: 'unixtime')]
    public function unixtime(TranslatorInterface $tl)
    {
        $data = [
            'meta_robots' => 'index,follow',
            'meta_title'  => $tl->trans('Unix-Time'),
            'meta_desc'   => $tl->trans('Die Unix-Time gibt die Anzahl der Sekunden seit dem 1.1.1970 00:00:00 UTC an.'),
            'header'      => $tl->trans('Unix-Time'),
            'message'     => $tl->trans('Die Unix-Time gibt die Anzahl der Sekunden seit dem 1.1.1970 00:00:00 UTC an.'),
            'link'        => $tl->trans('https://de.wikipedia.org/wiki/Unixzeit'),
        ];
        return $this->render('sites/unixtime.html.twig',
            ['data' => $data]);
    }

    /**
     * Check if date is valid
     */
    #[Route(path: '/checkdate', name: 'checkdate')]
    public function checkdate(TranslatorInterface $tl)
    {
        $data = [
            'meta_robots'   => 'index,follow',
            'meta_title'    => $tl->trans('Prüfen, ob ein Datum gültig ist'),
            'meta_desc'     => $tl->trans('Prüft, ob das angegebene Datum gültig ist.'),
            'header'        => $tl->trans('Gültiges Datum'),
            'message'       => $tl->trans('Prüft, ob das angegebene Datum gültig ist.'),
        ];
        return $this->render('sites/checkdate.html.twig', ['data' => $data]);
    }

    /**
     * Week
     */
    #[Route(path: '/week', name: 'week')]
    public function week(TranslatorInterface $tl)
    {
        $data = [
            'meta_robots' => 'index,follow',
            'meta_title'  => $tl->trans('Kalenderwoche ermitteln'),
            'meta_desc'   => $tl->trans('Die Kalenderwoche zu einem bestimmten Datum ermitteln.'),
            'header'      => $tl->trans('Kalenderwoche'),
            'message'     => $tl->trans('Die Kalenderwoche definiert nach ISO 8601. KW1 eines Jahres ist diejenige, die den ersten Donnerstag enthält.'),
            'link'        => $tl->trans('https://de.wikipedia.org/wiki/Woche#Z.C3.A4hlweise_nach_ISO_8601'),
        ];
        return $this->render('sites/week.html.twig', ['data' => $data]);
    }

    /**
     * Check if leap year or not
     */
    #[Route(path: '/leapyear', name: 'leapyear')]
    public function leapyear(TranslatorInterface $tl)
    {
        $data = [
            'meta_robots' => $tl->trans('index,follow'),
            'meta_title'  => $tl->trans('Ist es ein Schaltjahr oder nicht?'),
            'meta_desc'   => $tl->trans('Prüfen, ob das angegeben Jahr ein Schaltjahr ist oder nicht.'),
            'header'      => $tl->trans('Schaltjahr'),
            'message'     => $tl->trans('Ein Schaltjahr ist ein Jahr, das im Unterschied zum Gemeinjahr einen zusätzlichen Schalttag am 29.2. enthält.'),
            'link'        => $tl->trans('https://de.wikipedia.org/wiki/Schaltjahr'),
        ];
        return $this->render('sites/leapyear.html.twig', ['data' => $data]);
    }

    /**
     * Calculate age
     */
    #[Route(path: '/age', name: 'age')]
    public function age(TranslatorInterface $tl)
    {
        $data = [
            'meta_robots' => 'index,follow',
            'meta_title'  => $tl->trans('Das Alter ermitteln'),
            'meta_desc'   => $tl->trans('Das Alter für ein gegebenes Datum ermitteln.'),
            'header'      => $tl->trans('Alter'),
            'message'     => $tl->trans('Das Alter für ein gegebenes Datum ermitteln.'),
        ];
        return $this->render('sites/age.html.twig', ['data' => $data]);
    }

    /**
     * Progress
     */
    #[Route(path: '/progress', name: 'progress')]
    public function progress(TranslatorInterface $tl)
    {
        $data = [
            'meta_robots'       => 'index,follow',
            'meta_title'        => $tl->trans('Wie ist der Fortschritt'),
            'meta_desc'         => $tl->trans('Der aktuell vergangene Zeitraum von Anfang bis Ende in Prozent.'),
            'header'            => $tl->trans('Fortschritt'),
            'message'           => $tl->trans('Der aktuell vergangene Zeitraum von Anfang bis Ende in Prozent.'),
            'defaultstartdate'  => date('Y').'-01-01',
            'defaultenddate'    => date('Y').'-12-31',
        ];
        return $this->render('sites/progress.html.twig', ['data' => $data]);
    }

    /**
     * Average annual CO² level
     */
    #[Route(path: '/co2', name: 'co2')]
    public function co2(TranslatorInterface $tl)
    {
        $data = [
            'meta_robots' => 'index,follow',
            'meta_title'  => $tl->trans('CO² im Jahr'),
            'meta_desc'   => $tl->trans('Durchschnittlicher Jahreswert für C0² in der Athmosphäre in PPM'),
            'header'      => $tl->trans('C0² im Jahr'),
            'message'     => $tl->trans('Durchschnittlicher Jahreswert für C0² in der Athmosphäre in PPM'),
            'link'        => 'https://gml.noaa.gov/ccgg/trends/data.html',
            'minyear'     => 1959,
            'maxyear'     => intval(date('Y')) -1,
            'defaultyear' => intval(date('Y')) -1,
        ];
        return $this->render('sites/co2.html.twig', ['data' => $data]);
    }

    /**
     * Reverse function for annual CO² level
     */
    #[Route(path: '/co2reverse', name: 'co2reverse')]
    public function co2reverse(TranslatorInterface $tl)
    {
        $data = [
            'meta_robots' => 'index,follow',
            'meta_title'  => $tl->trans('Jahr mit CO² Wert'),
            'meta_desc'   => $tl->trans('In welchem Jahr lag der C0² Anteil in der Athmosphäre auf dem angegebenen Wert'),
            'header'      => $tl->trans('Jahr mit CO² Wert'),
            'message'     => $tl->trans('In welchem Jahr lag der C0² Anteil in der Athmosphäre auf dem angegebenen Wert'),
            'link'        => 'https://gml.noaa.gov/ccgg/trends/data.html',
            'defaultyear' => intval(date('Y')) -1,
        ];
        return $this->render('sites/co2reverse.html.twig', ['data' => $data]);
    }

    /**
     * Public holidays in Germany
     */
    #[Route(path: '/germanpublicholidays', name: 'germanpublicholidays')]
    public function germanpublicholidays(TranslatorInterface $tl)
    {
        $data = [
            'meta_robots' => 'index,follow',
            'meta_title'  => $tl->trans('Gesetzliche Feiertage in Deutschland'),
            'meta_desc'   => $tl->trans('Eine Api für die gesetzlichen Feiertage in Deutschland und seinen Bundesländern.'),
            'header'      => $tl->trans('Gesetzliche Feiertage in Deutschland'),
            'message'     => $tl->trans('Eine Api für die gesetzlichen Feiertage in Deutschland und seinen Bundesländern.'),
        ];
        return $this->render('sites/germanpublicholidays.html.twig', ['data' => $data]);
    }

}