<?php
declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi\Parser;

use Alexvkokin\TelegramBotApi\Type\Type;
use ReflectionClass;
use ReflectionNamedType;

final readonly class ResponseParser
{
    /**
     * @template TClass of Type
     * @param class-string<TClass> $className
     * @param array $bodyResult
     * @return Type
     * @throws \ReflectionException
     */
    public function asObject(string $className, array $bodyResult): Type
    {
        $reflection = new ReflectionClass($className);

        $properties = [];

        foreach ($reflection->getConstructor()?->getParameters() ?? [] as $property) {

            $nameProperty = $property->getName();
            /** @var ReflectionNamedType|null $typeProperty */
            $typeProperty = $property->getType();

            if ($typeProperty === null) {
                continue;
            }

            $typeName = $typeProperty->getName();
            $subBody = $bodyResult[$nameProperty] ?? null;

            if ($subBody === null) {
                continue;
            }

            if (is_array($subBody) && !class_exists($typeName)) {
                continue;
            }

            if (is_array($subBody)) {
                $properties[$nameProperty] = $this->asObject($typeName, $subBody);
            } else {
                $properties[$nameProperty] = $subBody;
            }
        }

        return new $className(...$properties);
    }
}