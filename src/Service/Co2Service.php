<?php

namespace App\Service;

class Co2Service
{

    private $dataDownloadUrl = 'https://gml.noaa.gov/webdata/ccgg/trends/co2/co2_annmean_mlo.csv';
    
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

        if (array_key_exists($year, $years)) {
            $rf = $years[$year];
        }

        return $rf;
    }
}
