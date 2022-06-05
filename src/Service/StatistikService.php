<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class StatistikService
{
    private $params;

    /**
     * Constructor
     *
     * @param ParameterBagInterface $parameterBag
     */
    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->params = $parameterBag;
    }

    public function getSiteid()
    {
        return $this->params->get('matomo.siteid');
    }

    public function getUrl()
    {
        return $this->params->get('matomo.url');
    }

    public function getToken()
    {
        return $this->params->get('matomo.token');
    }
}