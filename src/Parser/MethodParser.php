<?php
declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi\Parser;

use Alexvkokin\TelegramBotApi\Method\Method;
use Alexvkokin\TelegramBotApi\Type\InputFile;
use Alexvkokin\TelegramBotApi\Type\Type;
use ReflectionClass;

final readonly class MethodParser
{
    public function getName(Method $method): string
    {
        $reflection = new ReflectionClass($method);
        return $reflection->getShortName();
    }

    /**
     * @return array<string, mixed>
     */
    public function getParams(Method $method): array
    {
        return array_filter($this->getAllParams($method), fn($value) => !($value instanceof InputFile));
    }

    /**
     * @return array<InputFile>
     */
    public function getFiles(Method $method): array
    {
        return array_filter($this->getAllParams($method), fn($value) => $value instanceof InputFile);
    }

    /**
     * @return array<string, mixed>
     */
    private function getAllParams(Method $method): array
    {
        $reflection = new ReflectionClass($method);

        $properties = [];

        foreach ($reflection->getConstructor()?->getParameters() ?? [] as $property) {

            $nameProperty = $property->getName();

            $valueProperty = $method->$nameProperty;

            if ($valueProperty === null) {
                continue;
            }

            $valueIdScalar = !is_array($valueProperty) && !($valueProperty instanceof Type);
            $valueIsFile = $valueProperty instanceof InputFile;

            if ($valueIdScalar) {
                $valueProperty = (string)$valueProperty;
            } else if (!$valueIsFile) {
                $valueProperty = $this->recursiveConvertToArray($valueProperty);
            }

            $properties[$nameProperty] = $valueProperty;
        }

        return $properties;
    }

    function recursiveConvertToArray(mixed $data): mixed
    {
        if (is_object($data)) {
            $data = array_filter(get_object_vars($data));
        }

        if (is_array($data)) {
            return array_map([$this, 'recursiveConvertToArray'], $data);
        }

        return $data;
    }
}