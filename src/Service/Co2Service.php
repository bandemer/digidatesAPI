<?php

namespace App\Service;

class Co2Service
{
    /**
     * Download-URL for CO2-Leves per year in CSV format
     * @var string
     */
    private $dataDownloadUrl = 'https://gml.noaa.gov/webdata/ccgg/trends/co2/co2_annmean_mlo.csv';

    /**
     * Path to store file
     * @var string
     */
    private $dataPath = '../docs/co2_annmean_mlo.csv';

    public function __construct()
    {
        if (!file_exists($this->dataPath)) {
            $data = file_get_contents($this->dataDownloadUrl);
            file_put_contents($this->dataPath, $data);
        }
    }

    /**
     * CO² Level
     *
     * @param string $year
     * @return float
     */
    public function co2(string $year)
    {
        $rf = 0;
        $years = $this->getYears();
        if (array_key_exists($year, $years)) {
            $rf = $years[$year];
        }

        return $rf;
    }

    /**
     * Search for years with given CO2-Level
     *
     * @param float $co2
     * @return array
     */
    public function reverse(float $co2)
    {
        $rA = [];
        $dist = [];

        //Wich year is nearest
        foreach ($this->getYears() AS $year => $yearValue) {
            $dist[] = [
                'dist' => abs($yearValue - $co2),
                'year' => $year,
                'yearvalue' => $yearValue
            ];
        }

        //Maximum value differences between years
        $maxDistance = 0;
        $last = 0;
        foreach ($this->getYears() AS $yearValue) {
            if ($last > 0) {
                $diff = abs($yearValue - $last);
                if ($diff > $maxDistance) {
                    $maxDistance = $diff;
                }
            }
            $last = $yearValue;
        }

        //find nearest year
        $distances  = array_column($dist, 'dist');
        array_multisort($distances, SORT_DESC, $dist);
        $found = array_pop($dist);

        //check if distance is in possible range
        if ($found['dist'] <= $maxDistance) {
            $rA = ['year' => $found['year'], 'co2' => $found['yearvalue']];
        }

        return $rA;
    }

    /**
     * get CO² values for years
     *
     * @return array
     */
    private function getYears()
    {
        $years = [];
        $pattern = '/^([0-9]{4,4}),([0-9]+\.[0-9]{2,2}),.*$/';

        $handle = fopen($this->dataPath, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $matches = [];
                if (preg_match($pattern, $line, $matches)) {
                    $years[$matches[1]] = floatval($matches[2]);
                }
            }
            fclose($handle);
        }
        return $years;
    }
}
