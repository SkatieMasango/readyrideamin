<?php

namespace App\Enums\Attributes;

use ReflectionClassConstant;

trait EnumAttributes
{
    public function label(): string
    {
        return self::getDescription($this);
    }

    public static function getDescription(self $enum): string
    {
        $ref = new ReflectionClassConstant(self::class, $enum->name);
        $classAttributes = $ref->getAttributes(Description::class);

        if (count($classAttributes) === 0) {
            return str($enum->value)->headline()->toString();
        }

        return $classAttributes[0]->newInstance()->description;
    }

    public static function casesArray(): array
    {
        return array_combine(self::names(), self::values());
    }

    public static function all(): array
    {
        return collect(self::cases())
            ->map(function ($enum) {
                return [
                    'description' => self::getDescription($enum),
                    'name' => $enum->name,
                    'value' => $enum->value,
                ];
            })->toArray();
    }

    public static function except(array $enums, bool $asText = false): array|string
    {
        $enumCollection = collect(self::values())
            ->diff(collect($enums)->map(fn ($enum) => $enum->value));

        if ($asText) {
            return $enumCollection->implode(',');
        }

        return $enumCollection->toArray();
    }

    public static function only(array $enums, bool $asText = false): array|string
    {
        $enumCollection = collect($enums)->map(fn (self $enum) => $enum->value);
        if ($asText) {
            return $enumCollection->implode(',');
        }

        return $enumCollection->toArray();
    }

    public static function formatAll(string $valueKey = 'value', string $nameKey = 'name', bool $asText = false): array|string
    {
        $enumCollection = collect(self::cases());
        if ($asText) {
            return $enumCollection->pluck('value')->implode(',');
        }

        return $enumCollection->map(function ($enum) use ($nameKey, $valueKey) {
            return [
                $nameKey => self::getDescription($enum),
                $valueKey => $enum->value,
            ];
        })->toArray();
    }

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function descriptions(): array
    {
        return collect(self::cases())
            ->map(function ($enum) {
                return [
                    'description' => self::getDescription($enum),
                ];
            })->pluck('description')->toArray();
    }
}
