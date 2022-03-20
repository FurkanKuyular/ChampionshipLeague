<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use Psr\Container\ContainerInterface;

class AbstractService
{
    public function __construct(protected ContainerInterface $container, protected LoggerInterface $logger)
    {
    }
}