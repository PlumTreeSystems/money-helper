<?php

namespace MoneyHelper;

class Helper
{
    public static function formatMoney($unformated)
    {
        return bcdiv((string)$unformated, 1, 2);
    }

    /**
     * Format cents to money with precision of 2 numbers
     * @param mixed $unformated
     * @return string
     */
    public static function formatCents($unformated)
    {
        return self::formatMoney(((int)$unformated) / 100);
    }

    public static function toCentsSafe(float $amount): int
    {
        return (int)((string)($amount * 100));
    }

    public static function calcVat($baseAmount, $vatPercent)
    {
        return $baseAmount * ($vatPercent / 100 / 100);
    }

    /**
     * Format float value to cents safe
     * @param $unformated
     * @return int
     */
    public static function formatCentsToInt($unformated): int
    {
        if (is_int($unformated)) {
            return (int)($unformated * 100);
        }
        if (!is_string($unformated)) {
            $unformated = (string)$unformated;
        }
        $exploded = explode('.', $unformated, 2);
        if (isset($exploded[1])) {
            switch (strlen($exploded[1])) {
                case 1:
                    return (int)implode('', [...$exploded, '0']);
                case 2:
                    return (int)implode('', $exploded);
                default:
                    return (int)($exploded[0] . substr($exploded[1], 0, 2));
            }
        }
        return ((int)$exploded[0]) * 100;
    }

    public static function formatCentsToCurrency(int $cents)
    {
        $cents = (string)$cents;
        switch (strlen($cents)) {
            case 0:
                return 0;
            case 1:
                return "0.0" . $cents;
            case 2:
                return "0." . $cents;
            default:
                return substr($cents, 0, strlen($cents) - 2) . '.' . substr($cents, -2);
        }
    }
}
