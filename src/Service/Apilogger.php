<?php

namespace App\Service;

use Psr\Log\LoggerInterface;

/**
 * Logging API calls to var/log/apiusage.log
 * see also config/packages/monolog.yaml and config/services.yaml for configuration
 *
 */
class Apilogger
{
    private $apiLogger;

    public function __construct(LoggerInterface $logger)
    {
        $this->apiLogger = $logger;
    }

    /**
     * Logging API usage
     */
    public function log(string $message): void
    {
        $remoteip = '';
        if (array_key_exists('REMOTE_ADDR', $_SERVER)) {
            $remoteip = $_SERVER['REMOTE_ADDR'];
        }
        $useragent = '';
        if (array_key_exists('HTTP_USER_AGENT', $_SERVER)) {
            $useragent = $_SERVER['HTTP_USER_AGENT'];
        }
        $referer = '';
        if (array_key_exists('HTTP_REFERER', $_SERVER)) {
            $referer = $_SERVER['HTTP_REFERER'];
        }
        $this->apiLogger->info($message,[
            'remoteip'  => $remoteip,
            'useragent' => $useragent,
            'referer'   => $referer]);
    }
}