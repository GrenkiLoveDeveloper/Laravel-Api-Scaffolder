<?php

declare(strict_types=1);

namespace App\Abstracts\DTO;

use ReflectionClass;
use RuntimeException;

abstract class BaseDTOAbstract {
    /**
     * Создание DTO из массива с учетом типов.
     *
     * @param array<mixed> $data
     * @return static
     */
    public static function createFromArray(array $data): static {
        $class = static::class;

        $constructor = new ReflectionClass($class)->getConstructor();
        $parameters = $constructor?->getParameters();

        if (! $constructor || ! $parameters) {
            throw new RuntimeException("Constructor not found in {$class}.");
        }

        $args = [];

        foreach ($parameters as $parameter) {
            $name = $parameter->getName();
            $args[] = $data[$name] ?? null;
        }

        return new $class(...$args);
    }

    /**
     * Преобразование DTO в массив.
     *
     * @return array<mixed>
     */
    public function toArray(): array {
        return get_object_vars($this);
    }
}
