<?php

namespace App\Service;

class Holidays
{
    /*
     * Supported Years with date of Easter sunday according to
     * https://nl.wikipedia.org/wiki/Paas-_en_pinksterdatum
     */
    private $supportedYears =
        [
            2013 => '2013-03-31',
            2014 => '2014-04-20',
            2015 => '2015-04-05',
            2016 => '2016-03-27',
            2017 => '2017-04-16',
            2018 => '2018-04-01',
            2019 => '2019-04-21',
            2020 => '2020-04-12',
            2021 => '2021-04-04',
            2022 => '2022-04-17',
            2023 => '2023-04-09',
            2024 => '2024-03-31',
            2025 => '2025-04-20',
            2026 => '2026-04-05',
            2027 => '2027-03-28',
            2028 => '2028-04-16',
            2029 => '2029-04-01',
            2030 => '2030-04-21',
            2031 => '2031-04-13',
            2032 => '2032-03-28',
            2033 => '2033-04-17',
            2034 => '2034-04-09',
            2035 => '2035-04-25',
            2036 => '2036-04-13',
            2037 => '2037-04-05',
            2038 => '2038-04-25',
            2039 => '2039-04-10',
            2040 => '2040-04-01',
            2041 => '2041-04-21',
            2042 => '2042-04-06',
            2043 => '2043-03-29',
        ];

    /**
     * Germany and her federal states
     * @var array[]
     */
    private $regions = [
        'de'    => [
            'title' => [ 'de' => 'Deutschland', 'en' => 'Germany'],
            'holidays' => ['Neujahr', 'Karfreitag', 'Ostermontag',
                'Tag der Arbeit', 'Christi Himmelfahrt', 'Pfingstmontag',
                'Tag der Deutschen Einheit', '1. Weihnachtstag',
                '2. Weihnachtstag']
            ],
        'de-bw' => [
            'title' => [ 'de' => 'Baden-Württemberg', 'en' => 'Baden-Württemberg'],
            'holidays' => ['Neujahr', 'Erscheinungsfest', 'Karfreitag',
                'Ostermontag', 'Tag der Arbeit', 'Christi Himmelfahrt',
                'Pfingstmontag', 'Fronleichnam', 'Tag der Deutschen Einheit',
                'Allerheiligen', '1. Weihnachtstag', '2. Weihnachtstag']
            ],
        'de-by' => [
            'title' => [ 'de' => 'Bayern', 'en' => 'Bavaria'],
            'holidays' => ['Neujahr', 'Heilige Drei Könige', 'Karfreitag',
                'Ostermontag', 'Tag der Arbeit', 'Christi Himmelfahrt',
                'Pfingstmontag', 'Fronleichnam', 'Tag der Deutschen Einheit',
                'Allerheiligen', '1. Weihnachtstag', '2. Weihnachtstag']
            ],
        'de-be' => [
            'title' => [ 'de' => 'Berlin', 'en' => 'Berlin'],
            'holidays' => ['Neujahr', 'Internationaler Frauentag',
                'Karfreitag', 'Ostermontag', 'Tag der Arbeit',
                'Christi Himmelfahrt', 'Pfingstmontag',
                'Tag der Deutschen Einheit', '1. Weihnachtstag',
                '2. Weihnachtstag']
            ],
        'de-bb' => [
            'title' => [ 'de' => 'Brandenburg', 'en' => 'Brandenburg'],
            'holidays' => ['Neujahrstag', 'Karfreitag', 'Ostersonntag',
                'Ostermontag', 'Tag der Arbeit', 'Christi Himmelfahrtstag',
                'Pfingstsonntag', 'Pfingstmontag','Tag der Deutschen Einheit',
                'Reformationsfest', '1. Weihnachtstag', '2. Weihnachtstag']
            ],
        'de-hb' => [
            'title' => [ 'de' => 'Bremen', 'en' => 'Bremen'],
            'holidays' => ['Neujahrstag', 'Karfreitag', 'Ostermontag',
                '1. Mai', 'Himmelfahrtstag', 'Pfingstmontag',
                'Tag der Deutschen Einheit', '1. Weihnachtstag',
                '2. Weihnachtstag']
            ],
        'de-hh' => [
            'title' => [ 'de' => 'Hamburg', 'en' => 'Hamburg'],
            'holidays' => ['Neujahrstag', 'Karfreitag', 'Ostermontag',
                '1. Mai', 'Himmelfahrtstag', 'Pfingstmontag',
                'Tag der Deutschen Einheit', '31. Oktober', '1. Weihnachtstag',
                '2. Weihnachtstag']
            ],
        'de-he' => [
            'title' => [ 'de' => 'Hessen', 'en' => 'Hesse'],
            'holidays' => ['Neujahr', 'Karfreitag', 'Ostermontag',
                'Tag der Arbeit', 'Christi Himmelfahrt', 'Pfingstmontag',
                'Fronleichnam', 'Tag der Deutschen Einheit', '1. Weihnachtstag',
                '2. Weihnachtstag']
            ],
        'de-mv' => [
            'title' => [ 'de' => 'Mecklenburg-Vorpommern', 'en' => 'Mecklenburg-Vorpommern'],
            'holidays' => ['Neujahrstag', 'Frauentag', 'Karfreitag',
                'Ostermontag', '1. Mai', 'Christi-Himmelfahrtstag',
                'Pfingstmontag', 'Tag der Deutschen Einheit', 'Lower Saxony',
                '1. Weihnachtstag', '2. Weihnachtstag']
            ],
        'de-ni' => [
            'title' => [ 'de' => 'Niedersachsen', 'en' => 'Lower Saxony'],
            'holidays' => ['Neujahrstag', 'Karfreitag', 'Ostermontag',
                '1. Mai', 'Himmelfahrtstag', 'Pfingstmontag',
                'Tag der Deutschen Einheit', 'Reformationstag',
                '1. Weihnachtstag', '2. Weihnachtstag']
            ],
        'de-nw' => [
            'title' => [ 'de' => 'Nordrhein-Westfalen', 'en' => 'North Rhine-Westphalia'],
            'holidays' => ['Neujahrstag', 'Karfreitag', 'Ostermontag',
                'Tag des Bekenntnisses zu Freiheit und Frieden, sozialer Gerechtigkeit, Völkerversöhnung und Menschenwürde',
                'Christi-Himmelfahrts-Tag', 'Pfingstmontag', 'Fronleichnamstag',
                'Tag der Deutschen Einheit', 'Allerheiligentag',
                '1. Weihnachtstag', '2. Weihnachtstag']
            ],
        'de-rp' => [
            'title' => [ 'de' => 'Rheinland-Pfalz', 'en' => 'Rhineland-Palatinate'],
            'holidays' => ['Neujahrstag', 'Karfreitag', 'Ostermontag',
                '1. Mai', 'Christi Himmelfahrt', 'Pfingstmontag',
                'Fronleichnamstag', 'Tag der Deutschen Einheit',
                'Allerheiligentag', '1. Weihnachtstag', '2. Weihnachtstag']
            ],
        'de-sl' => [
            'title' => [ 'de' => 'Saarland', 'en' => 'Saarland'],
            'holidays' => ['Neujahrstag', 'Karfreitag', 'Ostermontag',
                '1. Mai', 'Christi Himmelfahrtstag', 'Pfingstmontag',
                'Fronleichnamstag', 'Maria Himmelfahrtstag',
                'Tag der Deutschen Einheit', 'Allerheiligentag',
                '1. Weihnachtstag', '2. Weihnachtstag']
            ],
        'de-sn' => [
            'title' => [ 'de' => 'Sachsen', 'en' => 'Saxony'],
            'holidays' => ['Neujahr', 'Karfreitag', 'Ostermontag',
                'Tag der Arbeit', 'Christi Himmelfahrt', 'Pfingstmontag',
                'Fronleichnam (nur in durch Rechtsverordnung bestimmten Regionen)',
                'Tag der Deutschen Einheit', 'Reformationsfest',
                'Buß- und Bettag', '1. Weihnachtstag', '2. Weihnachtstag']
            ],
        'de-st' => [
            'title' => [ 'de' => 'Sachsen-Anhalt', 'en' => 'Saxony-Anhalt'],
            'holidays' => ['Neujahr', 'Heilige Drei Könige', 'Karfreitag',
                'Ostermontag', '1. Mai', 'Christi Himmelfahrt', 'Pfingstmontag',
                'Tag der Deutschen Einheit', 'Reformationstag',
                '1. Weihnachtstag', '2. Weihnachtstag']
            ],
        'de-sh' => [
            'title' => [ 'de' => 'Schleswig-Holstein', 'en' => 'Schleswig-Holstein'],
            'holidays' => ['Neujahrstag', 'Karfreitag', 'Ostermontag',
                '1. Mai', 'Himmelfahrtstag', 'Pfingstmontag',
                'Tag der Deutschen Einheit', 'Reformationstag',
                '1. Weihnachtstag', '2. Weihnachtstag']
            ],
        'de-th' => [
            'title' => [ 'de' => 'Thüringen', 'en' => 'Thuringia'],
            'holidays' => ['Neujahrstag', 'Karfreitag', 'Ostermontag',
                '1. Mai', 'Christi Himmelfahrt', 'Pfingstmontag',
                'Fronleichnam (nur in durch Rechtsverordnung bestimmten Regionen)',
                'Weltkindertag', 'Tag der Deutschen Einheit', 'Reformationstag',
                '1. Weihnachtstag', '2. Weihnachtstag']
            ]
    ];


    /**
     * Return array of supported years
     * @return int[]
     */
    public function getSupportedYears() : array
    {
        return array_keys($this->supportedYears);
    }

    /**
     * Return array of supported regions
     * @return string[]
     */
    public function getSupportedRegions() : array
    {
        $rA = [];
        foreach ($this->regions AS $rk => $rv) {
            $rA[$rk] = $rv['title'];
        }
        return $rA;
    }

    /**
     * @param int $year
     * @param string $region
     */
    public function getHolidays(int $year, string $region) : array
    {
        $days = [];
        foreach ($this->regions[$region]['holidays'] AS $d) {
            $method = preg_replace('/[^0-9A-Za-z]/', '', $d);
            $method = 'holiday'.ucfirst(strtolower($method));
            if (method_exists($this, $method)) {
                $days[$this->$method($year)] = $d;
            } else {
                throw new \Exception('Method for holiday '.$method.' does not exist');
            }
        }

        //Special single holiday in Bremen
        if ($year == 2017 AND $region == 'DE-HB') {
            $days['2017-10-31'] = "500. Jahrestag der Reformation";
            ksort($days);
        }
        return $days;
    }

    private function holidayNeujahr(int $year) : string
    {
        return $year.'-01-01';
    }

    private function holidayNeujahrstag(int $year) : string
    {
        return $this->holidayNeujahr($year);
    }

    private function holidayErscheinungsfest(int $year) : string
    {
        return $year.'-01-06';
    }

    private function holidayHeiligedreiknige(int $year) : string
    {
        return $this->holidayErscheinungsfest($year);
    }

    private function holidayInternationalerfrauentag(int $year) : string
    {
        return $year.'-03-08';
    }

    private function holidayFrauentag(int $year) : string
    {
        return $this->holidayInternationalerfrauentag($year);
    }

    private function holidayKarfreitag(int $year) : string
    {
        $ostern = $this->supportedYears[$year];
        $ts = new \DateTime($ostern);
        $ts->modify('-2 days');
        return $ts->format('Y-m-d');
    }

    private function holidayOstersonntag(int $year) : string
    {
        return $this->supportedYears[$year];
    }

    private function holidayOstermontag(int $year) : string
    {
        $ostern = $this->supportedYears[$year];
        $ts = new \DateTime($ostern);
        $ts->modify('+1 days');
        return $ts->format('Y-m-d');
    }

    private function holidayTagderarbeit(int $year) : string
    {
        return $year.'-05-01';
    }

    private function holiday1mai(int $year) : string
    {
        return $this->holidayTagderarbeit($year);
    }

    private function holidayTagdesbekenntnisseszufreiheitundfriedensozialergerechtigkeitvlkervershnungundmenschenwrde(int $year) : string
    {
        return $this->holidayTagderarbeit($year);
    }

    private function holidayChristihimmelfahrt(int $year) : string
    {
        $ostern = $this->supportedYears[$year];
        $ts = new \DateTime($ostern);
        $ts->modify('+39 days');
        return $ts->format('Y-m-d');
    }

    private function holidayChristihimmelfahrtstag(int $year) : string
    {
        return $this->holidayChristihimmelfahrt($year);
    }

    private function holidayHimmelfahrtstag(int $year) : string
    {
        return $this->holidayChristihimmelfahrt($year);
    }

    private function holidayPfingstsonntag(int $year) : string
    {
        $ostern = $this->supportedYears[$year];
        $ts = new \DateTime($ostern);
        $ts->modify('+49 days');
        return $ts->format('Y-m-d');
    }

    private function holidayPfingstmontag(int $year) : string
    {
        $ostern = $this->supportedYears[$year];
        $ts = new \DateTime($ostern);
        $ts->modify('+50 days');
        return $ts->format('Y-m-d');
    }

    private function holidayFronleichnam(int $year) : string
    {
        $ostern = $this->supportedYears[$year];
        $ts = new \DateTime($ostern);
        $ts->modify('+60 days');
        return $ts->format('Y-m-d');
    }

    private function holidayFronleichnamstag(int $year) : string
    {
        return $this->holidayFronleichnam($year);
    }

    private function holidayFronleichnamnurindurchrechtsverordnungbestimmtenregionen(int $year) : string
    {
        return $this->holidayFronleichnam($year);
    }

    private function holidayMariahimmelfahrtstag(int $year) : string
    {
        return $year.'-08-15';
    }

    private function holidayWeltkindertag(int $year) : string
    {
        return $year.'-09-20';
    }

    private function holidayTagderdeutscheneinheit(int $year) : string
    {
        return $year.'-10-03';
    }

    private function holidayReformationsfest(int $year) : string
    {
        return $year.'-10-31';
    }

    private function holidayReformationstag(int $year) : string
    {
        return $this->holidayReformationsfest($year);
    }

    private function holiday31oktober(int $year) : string
    {
        return $this->holidayReformationsfest($year);
    }

    private function holidayBuundbettag(int $year) : string
    {
        $ts = new \DateTime($year.'-12-25');
        $wochentag = (int) $ts->format('w');
        if ($wochentag == 0) $wochentag = 7;
        $ts->modify('-'.(32 + $wochentag).' days');
        return $ts->format('Y-m-d');
    }

    private function holidayAllerheiligen(int $year) : string
    {
        return $year.'-11-01';
    }

    private function holidayAllerheiligentag(int $year) : string
    {
        return $this->holidayAllerheiligen($year);
    }

    private function holiday1weihnachtstag(int $year) : string
    {
        return $year.'-12-25';
    }

    private function holiday2weihnachtstag(int $year) : string
    {
        return $year.'-12-26';
    }

}
