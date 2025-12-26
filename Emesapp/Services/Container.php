<?php

namespace Services;

class Container
{
    protected array $bindings = [];
    public function bind(string $abstract, callable $concrete)
    {
        $this->bindings[$abstract] = $concrete;
    }

    public function get(string $abstract)
    {
        if (isset($this->bindings[$abstract])) {
            return $this->bindings[$abstract]($this);
        }

        return new $abstract;
    }


    static  function  Instance()
    {
        if (!isset($container)) {
            $name = Container::class;
            $container = new $name();
        }
        return $container;
    }
}
