<?php

namespace App\Tests\TestService;

use App\Kernel;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ReflectionMethod;

class StandardService
{
    public function getContainer(): ContainerInterface
    {
        $kernel = new Kernel(
            $_SERVER['APP_ENV'] ?? 'dev',
            $_SERVER['APP_DEBUG'] ?? ('prod' !== ($_SERVER['APP_ENV'] ?? 'dev'))
        );
        $kernel->boot();

        return $kernel->getContainer();
    }
    public function getReflectionMethodResult($class, string $function)
    {
        $reflectionMethod = new ReflectionMethod($class, $function);
        $reflectionMethod->setAccessible(true);
        $container = $this->getContainer();
        $containerClass = $container->get($class);
        return $reflectionMethod->invoke($containerClass);
    }

}