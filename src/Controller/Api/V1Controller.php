<?php

namespace App\Controller\Api;

use App\Service\DateAndTimeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class V1Controller extends AbstractController
{
    /**
     * UnixTime
     * @Route("/api/v1/unixtime", methods={"GET"})
     */
    public function unixtime(Request $req): JsonResponse
    {

        $timestamp = $req->get('timestamp', '');

        $response = ['time' => time()];
        $httpCode = 200;

        if ($timestamp != '') {

            $months = ['Jan' => 1, 'Feb' => 2, 'Mar' => 3, 'Apr' => 4,
                'May' => 5, 'Jun' => 6, 'Jul' => 7, 'Aug' => 8, 'Sep' => 9,
                'Oct' => 10, 'Nov' => 11, 'Dec' => 12];


            $m = [];
            //UTC-Timestamp
            if (preg_match("/^(Mon|Tue|Wed|Thu|Fri|Sat|Sun),".
                "\s(\d{2})\s(".implode('|', array_keys($months)).")".
                "\s(\d{4})\s(\d{2}):(\d{2}):(\d{2})( UTC)?$/",
                $timestamp, $m)) {

                $response['time'] = mktime($m[5], $m[6], $m[7], $months[$m[3]],
                    $m[2], $m[4]);
            }

            //YYYY-MM-DD HH:II:SS
            elseif (preg_match("/^([0-9]{4,4})-([0-9]{2,2})-([0-9]{2,2}) ".
                "([0-9]{2,2}):([0-9]{2,2}):([0-9]{2,2})$/",
                $timestamp, $m)) {

                $response['time'] = mktime($m[4], $m[5], $m[6], $m[2],
                    $m[3], $m[1]);

            //Unsupported Timestamp Format
            } else {
                $httpCode = 400;
                $response = ['error' => 'Error: Unsupported timestamp format'];
            }
        }

        return $this->json($response, $httpCode,
            ['Access-Control-Allow-Origin' => '*']
        );
    }

    /**
     * ISO week date
     *
     * @Route("/api/v1/week")
     */
    public function week(Request $req, DateAndTimeService $dts): JsonResponse
    {
        $date = $req->get('date', '');
        $kw = $dts->week($date);

        return $this->json(
            ['week' => $kw],
            200,
            ['Access-Control-Allow-Origin' => '*']
        );
    }

    /**
     * Schaltjahr
     * @Route("/api/v1/leapyear", methods={"GET"})
     */
    public function leapyear(Request $req, DateAndTimeService $dts): JsonResponse
    {
        $year = $req->get('year', '');
        $leapYear = $dts->leapYear($year);

        return $this->json(
            ['leapyear' => $leapYear],
            200,
            ['Access-Control-Allow-Origin' => '*']
        );
    }

    /**
     * Is ist a valid Date?
     *
     * @Route("/api/v1/checkdate", methods={"GET"})
     */
    public function checkdate(Request $req, DateAndTimeService $dts): JsonResponse
    {
        $date = $req->get('date', '');
        $returnBool = $dts->checkdate($date);

        if (is_null($returnBool)) {
            return $this->json(
                'Bad Request',
                400,
                ['Access-Control-Allow-Origin' => '*']
            );
        }

        return $this->json(
            ['checkdate' => $returnBool],
            200,
            ['Access-Control-Allow-Origin' => '*']
        );
    }

    /**
     * Day of Week
     *
     * @Route("/api/v1/weekday", methods={"GET"})
     */
    public function weekday(Request $req, DateAndTimeService $dts): JsonResponse
    {
        $date = $req->get('date', '');
        $ts = $dts->weekday($date);

        if ($ts > 0) {
            $returnInt = (int) date('w', $ts);
            return $this->json(
                ['weekday' => $returnInt],
                200,
                ['Access-Control-Allow-Origin' => '*']
            );
        } else {
            return $this->json('Bad Request',
                400,
                ['Access-Control-Allow-Origin' => '*']
            );
        }
    }

    /**
     * reached progress from one timestamp to another
     *
     * @Route("/api/v1/progress", methods={"GET"})
     */
    public function progress(Request $req, DateAndTimeService $dts): JsonResponse
    {
        $start = $req->get('start', '');
        $end = $req->get('end', '');
        $val = $dts->progress($start, $end);

        return $this->json(
            ['float' => $val / 100, 'percent' => round($val)], 200,
            ['Access-Control-Allow-Origin' => '*']
        );
    }

    /**
     * Get age for birthday
     *
     * @Route("/api/v1/age/{birthday}", methods={"GET"})
     */
    public function age(string $birthday, Request $req, DateAndTimeService $dts): JsonResponse
    {
        $response = [];
        $httpCode = 200;

        $matches = [];
        if (preg_match('/^([0-9]{4,4})-([0-9]{2,2})-([0-9]{2,2})$/', $birthday, $matches) AND
            checkdate($matches[2], $matches[3], $matches[1])) {

            $response = $dts->age($birthday);

        } else {

            $response = ['error' => 'Given birthday is not a valid date'];
            $httpCode = 400;
        }

        return $this->json($response, $httpCode,
            ['Access-Control-Allow-Origin' => '*']
        );
    }

    /**
     * CO² Parts per Million
     *
     * https://gml.noaa.gov/ccgg/trends/data.html
     *
     * @Route("/api/v1/co2/{year}", methods={"GET"})
     */
    public function co2(string $year, Request $req, DateAndTimeService $dts): JsonResponse
    {
        $response = [];
        $httpCode = 200;

        if (preg_match('/^([0-9]{4,4})$/', $year)) {

            $co2 = $dts->co2($year);
            if ($co2 == 0) {

                $httpCode = 400;
                $response = ['error' => 'Error! No value for given year.'];

            } else {
                $response['co2'] = $co2;
            }

        } else {

            $response = ['error' => 'Error! Not a valid year.'];
            $httpCode = 400;
        }

        return $this->json($response, $httpCode,
            ['Access-Control-Allow-Origin' => '*']
        );
    }

}