<?php

namespace App\Controller\Api;

use App\Service\DateAndTimeService;
use App\Service\Co2Service;
use App\Service\Holidays;
use App\Service\Apilogger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class V1Controller extends AbstractController
{
    private $logger;

    public function __construct(Apilogger $apiusageLogger)
    {
        date_default_timezone_set('UTC');
        $this->logger = $apiusageLogger;
    }

    /**
     * UnixTime
     */
    #[Route(path: '/api/v1/unixtime', methods: ['GET'])]
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

        $this->logger->log('API Call for unixtime');

        return $this->json($response, $httpCode,
            [
                'Access-Control-Allow-Origin' => '*',
                'X-Robots-Tag' => 'noindex, nofollow'
            ]
        );
    }

    /**
     * ISO week date
     */
    #[Route(path: '/api/v1/week')]
    public function week(Request $req, DateAndTimeService $dts): JsonResponse
    {
        $date = $req->get('date', '');
        $kw = $dts->week($date);

        $this->logger->log('API Call for week');

        return $this->json(
            ['week' => $kw],
            200,
            [
                'Access-Control-Allow-Origin' => '*',
                'X-Robots-Tag' => 'noindex, nofollow'
            ]
        );
    }

    /**
     * Schaltjahr
     */
    #[Route(path: '/api/v1/leapyear', methods: ['GET'])]
    public function leapyear(Request $req, DateAndTimeService $dts): JsonResponse
    {
        $year = $req->get('year', '');
        $leapYear = $dts->leapYear($year);

        $this->logger->log('API Call for leapyear');

        return $this->json(
            ['leapyear' => $leapYear],
            200,
            [
                'Access-Control-Allow-Origin' => '*',
                'X-Robots-Tag' => 'noindex, nofollow'
            ]
        );
    }

    /**
     * Is ist a valid Date?
     */
    #[Route(path: '/api/v1/checkdate', methods: ['GET'])]
    public function checkdate(Request $req, DateAndTimeService $dts): JsonResponse
    {
        $date = $req->get('date', '');
        $returnBool = $dts->checkdate($date);

        $this->logger->log('API Call for checkdate');

        if (is_null($returnBool)) {
            return $this->json(
                'Bad Request',
                400,
                [
                    'Access-Control-Allow-Origin' => '*',
                    'X-Robots-Tag' => 'noindex, nofollow'
                ]
            );
        }

        return $this->json(
            ['checkdate' => $returnBool],
            200,
            [
                'Access-Control-Allow-Origin' => '*',
                'X-Robots-Tag' => 'noindex, nofollow'
            ]
        );
    }

    /**
     * Day of Week
     */
    #[Route(path: '/api/v1/weekday', methods: ['GET'])]
    public function weekday(Request $req, DateAndTimeService $dts): JsonResponse
    {
        $date = $req->get('date', '');
        $ts = $dts->unixtime($date);

        $this->logger->log('API Call for weekday');

        if ($ts > 0) {
            $returnInt = (int) date('w', $ts);
            return $this->json(
                ['weekday' => $returnInt],
                200,
                [
                    'Access-Control-Allow-Origin' => '*',
                    'X-Robots-Tag' => 'noindex, nofollow'
                ]
            );
        } else {
            return $this->json('Bad Request',
                400,
                [
                    'Access-Control-Allow-Origin' => '*',
                    'X-Robots-Tag' => 'noindex, nofollow'
                ]
            );
        }
    }

    /**
     * reached progress from one timestamp to another
     */
    #[Route(path: '/api/v1/progress', methods: ['GET'])]
    public function progress(Request $req, DateAndTimeService $dts): JsonResponse
    {
        $start = $req->get('start', '');
        $end = $req->get('end', '');
        $val = $dts->progress($start, $end);

        $this->logger->log('API Call for progress');

        return $this->json(
            ['float' => $val / 100, 'percent' => round($val)], 200,
            [
                'Access-Control-Allow-Origin' => '*',
                'X-Robots-Tag' => 'noindex, nofollow'
            ]
        );
    }

    /**
     * Get age for birthday
     */
    #[Route(path: '/api/v1/age/{birthday}', methods: ['GET'])]
    public function age(string $birthday, DateAndTimeService $dts): JsonResponse
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

        $this->logger->log('API Call for age');

        return $this->json($response, $httpCode,
            [
                'Access-Control-Allow-Origin' => '*',
                'X-Robots-Tag' => 'noindex, nofollow'
            ]
        );
    }

    /**
     * CO² Parts per Million
     *
     * https://gml.noaa.gov/ccgg/trends/data.html
     */
    #[Route(path: '/api/v1/co2/{year}', methods: ['GET'])]
    public function co2(string $year, Co2Service $co2s): JsonResponse
    {
        $response = [];
        $httpCode = 200;

        if (preg_match('/^([0-9]{4,4})$/', $year)) {

            $co2 = $co2s->co2($year);
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

        $this->logger->log('API Call for co2');

        return $this->json($response, $httpCode,
            [
                'Access-Control-Allow-Origin' => '*',
                'X-Robots-Tag' => 'noindex, nofollow'
            ]
        );
    }

    /**
     * Years for given CO² Parts per Million
     *
     * https://gml.noaa.gov/ccgg/trends/data.html
     */
    #[Route(path: '/api/v1/co2/reverse/{co2}', methods: ['GET'])]
    public function co2reverse(string $co2, Request $req, Co2Service $co2s): JsonResponse
    {
        $response = [];
        $httpCode = 200;

        if (preg_match('/^[1-9][0-9]*(\.[0-9]+)?$/', $co2)) {

            $response = $co2s->reverse(floatval($co2));
            if (count($response) == 0) {

                $httpCode = 400;
                $response = ['error' => 'Error! No value for given year.'];
            }
        } else {

            $response = ['error' => 'Error! Not a valid float value.'];
            $httpCode = 400;
        }

        $this->logger->log('API Call for co2reverse');

        return $this->json($response, $httpCode,
            [
                'Access-Control-Allow-Origin' => '*',
                'X-Robots-Tag' => 'noindex, nofollow'
            ]
        );
    }

    /**
     * Supported years for German public holidays
     */
    #[Route(path: '/api/v1/germanpublicholidays/supportedyears', methods: ['GET'])]
    public function germanPublicHolidaysSupportedYears(Holidays $service): JsonResponse
    {
        $response = $service->getSupportedYears();
        $httpCode = 200;

        $this->logger->log('API Call for germanpublicholidays/supportedyears');

        return $this->json($response, $httpCode,
            [
                'Access-Control-Allow-Origin' => '*',
                'X-Robots-Tag' => 'noindex, nofollow'
            ]
        );
    }

    /**
     * Supported regions for German public holidays
     */
    #[Route(path: '/api/v1/germanpublicholidays/supportedregions', methods: ['GET'])]
    public function germanPublicHolidaysSupportedRegions(Holidays $service): JsonResponse
    {
        $response = $service->getSupportedRegions();
        $httpCode = 200;

        $this->logger->log('API Call for germanpublicholidays/supportedregions');

        return $this->json($response, $httpCode,
            [
                'Access-Control-Allow-Origin' => '*',
                'X-Robots-Tag' => 'noindex, nofollow'
            ]
        );
    }

    /**
     * German public holidays for given year and given region
     */
    #[Route(path: '/api/v1/germanpublicholidays', methods: ['GET'])]
    public function germanPublicHolidaysForRegion(Request $req, Holidays $service): JsonResponse
    {
        $response = [];
        $httpCode = 200;

        $region = $req->get('region', 'de');
        $year = $req->get('year', date('Y'));

        $region = strtolower($region);

        if (in_array($year, $service->getSupportedYears()) AND
            array_key_exists($region, $service->getSupportedRegions())) {
            $response = $service->getHolidays($year, $region);
        } else {
            $message = [];
            if (!in_array($year, $service->getSupportedYears())) {
                $message[] = 'given year is not supported';
            }
            if (!array_key_exists($region, $service->getSupportedRegions())) {
                $message[] = 'given region is not supported';
            }
            $response = ['error' => ucfirst(implode(', ', $message)).'.'];
            $httpCode = 400;
        }

        $this->logger->log('API Call for germanpublicholidays');

        return $this->json($response, $httpCode,
            [
                'Access-Control-Allow-Origin' => '*',
                'X-Robots-Tag' => 'noindex, nofollow'
            ]
        );
    }

    /**
     * Countdown to given date
     */
    #[Route(path: '/api/v1/countdown/{date}', methods: ['GET'])]
    public function countdown(string $date, DateAndTimeService $service): JsonResponse
    {
        $response = [];
        $httpCode = 200;

        //If no year given, assume next possible date
        if (preg_match('/^[0-1][0-9]-[0-3][0-9]$/', $date)) {
            if (intval(date('md')) > intval(str_replace('-', '', $date))) {
                $date = strval(intval(date('Y')) +1) . '-' . $date;
            } else {
                $date = date('Y').'-'.$date;
            }
        }

        //Check format of given date
        if (preg_match('/^[0-9]{4,4}-[0-1][0-9]-[0-3][0-9]$/', $date)) {

            //Check if given date is valid
            $check = explode('-', $date);
            if (checkdate(intval($check[1]), intval($check[2]), intval($check[0])) !== true) {
                $response = ['error' => 'Given date is not a valid date.'];
                $httpCode = 400;
            } else {

                //Check if given date lies in past
                $dateTs = new \DateTime($date);
                $today = new \DateTime('today');
                if ($today > $dateTs) {
                    $response = ['error' => 'Given date lies in the past.'];
                    $httpCode = 400;
                } else {
                    $response = $service->countdown($date);
                }
            }
        } else {
            $response = ['error' => 'Dates must be in format YYYY-MM-DD or MM-DD'];
            $httpCode = 400;
        }

        $this->logger->log('API Call for countdown');

        return $this->json($response, $httpCode,
            [
                'Access-Control-Allow-Origin' => '*',
                'X-Robots-Tag' => 'noindex, nofollow'
            ]
        );
    }
}