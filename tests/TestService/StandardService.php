<?php

namespace App\Tests\TestService;

use App\Kernel;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormFactoryInterface;
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

    public function getFormFactory(): FormFactoryInterface
    {
        return $this->getContainer()->get('form.factory');
    }

    public function getReflectionMethodResult($class, string $function)
    {
        $reflectionMethod = new ReflectionMethod($class, $function);
        $reflectionMethod->setAccessible(true);
        $container = $this->getContainer();
        $containerClass = $container->get($class);
        return $reflectionMethod->invoke($containerClass);
    }

    public function getReflectionMethodResultWithArgs($class, string $function, array $args)
    {
        $reflectionMethod = new ReflectionMethod($class, $function);
        $reflectionMethod->setAccessible(true);
        $container = $this->getContainer();
        $containerClass = $container->get($class);
        return $reflectionMethod->invokeArgs($containerClass, $args);
    }

}