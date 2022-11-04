<?php

namespace App\Service;

class Holidays
{
    /*
     * Supported Years with date of easter sunday
     * https://de.wikipedia.org/wiki/Osterdatum
     */
    private $supportedYears =
        [
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
        ];

    private $regions = [
        'DE'    => 'Deutschland',
        'DE-BW' => 'Baden-Württemberg',
        'DE-BY' => 'Bayern',
        'DE-BE' => 'Berlin',
        'DE-BB' => 'Brandenburg',
        'DE-HB' => 'Bremen',
        'DE-HH' => 'Hamburg',
        'DE-HE' => 'Hessen',
        'DE-MV' => 'Mecklenburg-Vorpommern',
        'DE-NI' => 'Niedersachsen',
        'DE-NW' => 'Nordrhein-Westfalen',
        'DE-RP' => 'Rheinland-Pfalz',
        'DE-SL' => 'Saarland',
        'DE-SN' => 'Sachsen',
        'DE-ST' => 'Sachsen-Anhalt',
        'DE-SH' => 'Schleswig-Holstein',
        'DE-TH' => 'Thüringen',
    ];


    /**
     * Return array of supported years
     * @return int[]
     */
    public function getSupportedYears()
    {
        return array_keys($this->supportedYears);
    }

    /**
     * Calculate german public holidays for given year
     *
     * @param int $year
     * @return array
     */
    public function germanPublicHolidays(int $year)
    {
        $days = [];

        $ostern = $this->supportedYears[$year];

        //Neujahr (1. Januar)
        $days['Neujahr'] = $year.'-01-01';

        //Karfreitag,
        $ts = new \DateTime($ostern);
        $ts->modify('-2 days');
        $days['Karfreitag'] = $ts->format('Y-m-d');

        //Ostermontag
        $ts = new \DateTime($ostern);
        $ts->modify('+1 days');
        $days['Ostermontag'] = $ts->format('Y-m-d');

        //Tag der Arbeit (1. Mai)
        $days['Tag der Arbeit'] = $year.'-05-01';

        //Christi Himmelfahrt
        $ts = new \DateTime($ostern);
        $ts->modify('+39 days');
        $days['Christi Himmelfahrt'] = $ts->format('Y-m-d');

         //Pfingstmontag
        $ts = new \DateTime($ostern);
        $ts->modify('+50 days');
        $days['Pfingstmontag'] = $ts->format('Y-m-d');

        //Tag der Deutschen Einheit (3. Oktober)
        $days['Tag der Deutschen Einheit'] = $year.'-10-03';

        //1. Weihnachtstag (25. Dezember)
        $days['1. Weihnachtstag'] = $year.'-12-25';

        //2. Weihnachtstag (26. Dezember)
        $days['2. Weihnachtstag'] = $year.'-12-26';

        return $days;
    }
}
