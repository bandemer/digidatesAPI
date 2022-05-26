<?php

namespace App\Service;

use function PHPUnit\Framework\isNull;

class DateAndTimeService
{

    /**
     * Kalenderwoche
     *
     * @param string $timestamp
     * @return int
     */
    public function week(string $timestamp)
    {
        $unixTime = time();
        if ($timestamp != '') {
            $unixTime = strtotime($timestamp);
        }

        $kw = (int) date('W', $unixTime);
        return $kw;
    }

    /**
     * Schaltjahr oder nicht
     *
     * @param string $timestamp
     * @return bool
     */
    public function leapYear(string $timestamp)
    {
        $leapYear = false;
        $unixTime = time();

        if ($timestamp != '') {

            if (preg_match('/^[0-9]{4,4}$/', $timestamp)) {

                $unixTime = mktime(1, 1, 1, 1, 1, $timestamp);

            } else {

                $unixTime = strtotime($timestamp);
            }
        }

        if (date('L', $unixTime) == '1') {
            $leapYear = true;
        }

        return $leapYear;
    }

    /**
     * Gültiges Datum oder nicht
     * @param string $date
     * @return bool
     */
    public function checkdate(string $date)
    {
        $returnBool = null;

        $matches = [];

        //YYYY-MM-DD
        if (preg_match('/^([0-2][0-9]{3,3})-([0-9]{2,2})-([0-9]{2,2})$/',
            $date, $matches)) {
            $returnBool = checkdate($matches[2], $matches[3], $matches[1]);
        }

        //DD.MM.YYYY
        if (preg_match('/^([0-9]{2,2})\.([0-9]{2,2})\.([0-2][0-9]{3,3})$/',
            $date, $matches)) {
            $returnBool = checkdate($matches[2], $matches[1], $matches[3]);
        }

        return $returnBool;
    }

    /**
     * @param string $date
     * @return false|int
     */
    public function weekday(string $date)
    {
        $ts = 0;

        //YYYY-MM-DD
        if (preg_match('/^([0-2][0-9]{3,3})-([0-9]{2,2})-([0-9]{2,2})$/',
            $date, $matches)) {
            $ts = mktime(0, 0, 0, $matches[2], $matches[3], $matches[1]);
        }

        //DD.MM.YYYY
        elseif (preg_match('/^([0-9]{2,2})\.([0-9]{2,2})\.([0-2][0-9]{3,3})$/',
            $date, $matches)) {
            $ts = mktime(0, 0, 0, $matches[2], $matches[1], $matches[3]);
        }

        //Current day
        elseif ($date == '') {
            $ts = time();
        }

        return $ts;
    }

    /**
     * @param string $start
     * @param string $end
     * @return float|int
     */
    public function progress(string $start, string $end)
    {
        $startTs = strtotime($start);
        $endTs = strtotime($end);

        $nowTs = time();

        return 100 / ($endTs - $startTs) * ($nowTs - $startTs);
    }
}
