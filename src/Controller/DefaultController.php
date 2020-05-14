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
     * Gültiges Datum
     *
     * @Route("/checkdate/{date}", name="checkdate", methods={"GET"})
     */
    public function checkdate(string $date)
    {
        $returnBool = false;

        $matches = [];
        if (preg_match('/^([0-2][0-9]{3,3})-([0-9]{2,2})-([0-9]{2,2})$/',
            $date, $matches)) {

            $returnBool = checkdate($matches[2], $matches[3], $matches[1]);
        }
        return $this->json(['checkdate' => $returnBool]);
    }

}