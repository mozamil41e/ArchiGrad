<?php

namespace App\Enums;

enum Grade: string
{
    case A = 'A';
    case BPlus = 'B+';
    case B = 'B';
    case CPlus = 'C+';
    case C = 'C';
    case F = 'F';
    case Pending = 'pending';

    public function weight(): ?int
    {
        return match ($this) {
            self::A => 95,
            self::BPlus => 85,
            self::B => 75,
            self::CPlus => 65,
            self::C => 55,
            self::F => 25,
            self::Pending => null,
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::A => 'bg-blue-100 text-blue-800',
            self::BPlus => 'bg-green-100 text-green-800',
            self::B => 'bg-teal-100 text-teal-800',
            self::CPlus => 'bg-yellow-100 text-yellow-800',
            self::C => 'bg-orange-100 text-orange-800',
            self::F => 'bg-red-100 text-red-800',
            self::Pending => 'bg-gray-100 text-gray-600',
        };
    }

    public function label(): string
    {
        return $this === self::Pending ? 'لم يتم التقييم بعد' : $this->value;
    }

    public static function fromWeight(?float $weight): self
    {
        return match (true) {
            $weight === null => self::Pending,
            $weight >= 90 => self::A,
            $weight >= 80 => self::BPlus,
            $weight >= 70 => self::B,
            $weight >= 60 => self::CPlus,
            $weight >= 50 => self::C,
            default => self::F,
        };
    }

    /**
     * @return array<int, string>
     */
    public static function assignable(): array
    {
        return array_map(fn (self $grade) => $grade->value, self::cases());
    }

    public static function validationRule(): string
    {
        return 'in:' . implode(',', self::assignable());
    }
}
