<?php

declare(strict_types=1);

namespace ScraperDash\Actor\Common;

use Psr\Container\ContainerInterface;
use ScraperDash\Actor\Common\Exception\DefinitionAlreadyExistsException;
use ScraperDash\Actor\Common\Exception\DefinitionNotFoundException;

/**
 * @template T of object
 */
class LazyServiceRepository implements ContainerInterface
{
    /**
     * @var array<string, class-string<T>>
     */
    private array $definitions = [];

    /**
     * @var array<class-string<T>, T>
     */
    private array $instances = [];

    /**
     * @return T
     */
    public function get(string $id): object
    {
        if (! $this->has($id)) {
            throw new DefinitionNotFoundException();
        }

        $definedClass = $this->definitions[$id];

        $instance = $this->instances[$definedClass] ?? null;
        if ($instance === null) {
            $instance = new $definedClass();
            $this->instances[$definedClass] = $instance;
        }

        return $instance;
    }

    /**
     * @param T|null $instance
     * @param class-string<T> $definedClass
     */
    public function add(string $id, string $definedClass, object|null $instance = null): void
    {
        if ($this->has($id)) {
            throw new DefinitionAlreadyExistsException();
        }

        $this->definitions[$id] = $definedClass;

        if ($instance !== null) {
            $this->instances[$definedClass] = $instance;
        }
    }

    public function has(string $id): bool
    {
        return array_key_exists($id, $this->definitions);
    }
}
