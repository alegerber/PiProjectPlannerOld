<?php declare(strict_types = 1);

namespace App\Tests\TestService;

use App\Kernel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use ReflectionMethod;

class StandardService
{
    public function getContainer(): ContainerInterface
    {
        global $app_env_test;
        $app_env_test = true;

        $kernel = new Kernel('dev', true);
        $kernel->boot();

        return $kernel->getContainer();
    }

    public function getFormFactory(): FormFactoryInterface
    {
        return $this->getContainer()->get('form.factory');
    }

    public function getEntityManger(): EntityManagerInterface
    {
        return $this->getContainer()->get('doctrine.orm.default_entity_manager');
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