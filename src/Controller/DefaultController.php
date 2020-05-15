<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * UnixTime
     *
     * @Route("/unixtime/{timestamp}", name="unixtime", methods={"GET"})
     */
    public function unixtime(string $timestamp = '')
    {
        $unixTime = time();
        if ($timestamp != '') {

            $unixTime = strtotime($timestamp);
        }

        return $this->json(['time' => $unixTime]);
    }

    /**
     * Kalenderwoche
     *
     * @Route("/week/{timestamp}", name="week", methods={"GET"})
     */
    public function week(string $timestamp = '')
    {
        $unixTime = time();
        if ($timestamp != '') {

            $unixTime = strtotime($timestamp);
        }

        $kw = (int) date('W', $unixTime);

        return $this->json(['week' => $kw]);
    }

    /**
     * Schaltjahr
     *
     * @Route("/leapyear/{timestamp}", name="leapyear", methods={"GET"})
     */
    public function leapyear(string $timestamp = '')
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

        return $this->json(['leapyear' => $leapYear]);
    }

    /**
     * Gültiges Datum?
     *
     * @Route("/checkdate/{date}", name="checkdate", methods={"GET"})
     */
    public function checkdate(string $date = '')
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

        if (is_null($returnBool)) {
            return new Response('Bad Request', 500);
        }

        return $this->json(['checkdate' => $returnBool]);
    }

    /**
     * Wochentag
     *
     * @Route("/weekday/{date}", name="weekday", methods={"GET"})
     */
    public function weekday(string $date = '')
    {
        $ts = 0;

        //YYYY-MM-DD
        if (preg_match('/^([0-2][0-9]{3,3})-([0-9]{2,2})-([0-9]{2,2})$/',
            $date, $matches)) {
            $ts = mktime(0, 0, 0, $matches[2], $matches[3], $matches[1]);
        }

        //DD.MM.YYYY
        if (preg_match('/^([0-9]{2,2})\.([0-9]{2,2})\.([0-2][0-9]{3,3})$/',
            $date, $matches)) {
            $ts = mktime(0, 0, 0, $matches[2], $matches[1], $matches[3]);
        }

        if ($ts > 0) {
            $returnInt = (int) date('w', $ts);
            return $this->json(['weekday' => $returnInt]);
        } else {
            return new Response('Bad Request', 500);
        }
    }

}