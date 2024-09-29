<?php

namespace App\Service;

class DateAndTimeService
{
    /**
     * Number of week in year according to ISO 8601
     * https://en.wikipedia.org/wiki/ISO_week_date
     */
    public function week(string $timestamp): int
    {
        $unixTime = time();
        if ($timestamp != '') {
            $unixTime = strtotime($timestamp);
        }
        return (int) date('W', $unixTime);
    }

    /**
     * Leap year or not
     */
    public function leapYear(string $timestamp): bool
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
     * Given date is valid or not
     */
    public function checkdate(string $date): bool
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
     * Returns unix time for given date string
     */
    public function unixtime(string $date): int
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
        //Current time
        elseif ($date == '') {
            $ts = time();
        }
        return $ts;
    }

    /**
     *  Progress between to timestamps
     */
    public function progress(string $start, string $end): float
    {
        $startTs    = strtotime($start);
        $endTs      = strtotime($end);
        $nowTs      = time();
        return 100 / ($endTs - $startTs) * ($nowTs - $startTs);
    }

    /**
     * Age of given date
     */
    public function age(string $birthday): array
    {
        $rA = [
            'age' => 0,
            'ageextended' => ['years' => 0, 'months' => 0, 'days' => 0]
        ];
        $birthdayTs = new \DateTime($birthday);
        $today = new \DateTime('today');
        if ($birthdayTs < $today) {
            $rA['age'] = intval($today->diff($birthdayTs)->format('%y'));
            $rA['ageextended']['years'] = intval($today->diff($birthdayTs)->format('%y'));
            $rA['ageextended']['months'] = intval($today->diff($birthdayTs)->format('%m'));
            $rA['ageextended']['days'] = intval($today->diff($birthdayTs)->format('%d'));
        }
        return $rA;
    }

    /**
     * Countdown to given date
     */
    public function countdown(string $date): array
    {
        $rA = [
            'daysonly' => 0,
            'countdown' => ['years' => 0, 'months' => 0, 'days' => 0]
        ];
        $dateTs = new \DateTime($date);
        $today = new \DateTime('today');
        if ($today < $dateTs) {
            $rA['daysonly'] = intval((strtotime($date) - time()) / 86400) +1;
            $rA['countdown']['years'] = intval($today->diff($dateTs)->format('%y'));
            $rA['countdown']['months'] = intval($today->diff($dateTs)->format('%m'));
            $rA['countdown']['days'] = intval($today->diff($dateTs)->format('%d'));
        }
        return $rA;
    }
}
