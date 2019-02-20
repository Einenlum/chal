<?php

namespace App\Infrastructure\Serializer;

abstract class Factory
{
    private $class;

    private $proxy;

    private $dependencies;

    public function __construct(string $class, string $proxy, array $dependencies = [])
    {
        $this->class        = $class;
        $this->proxy        = $proxy;
        $this->dependencies = $dependencies;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function getProxy()
    {
        return $this->proxy;
    }

    public function supportsObject($object): bool
    {
        return is_a($object, $this->class);
    }

    public function buildProxy($object): object
    {
        $reflection   = new \ReflectionClass($this->proxy);
        $dependencies = $this->dependencies;

        array_unshift($dependencies, $object);

        return $reflection->newInstanceArgs($dependencies);
    }
}
