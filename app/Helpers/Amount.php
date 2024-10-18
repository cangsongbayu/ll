<?php

namespace App\Helpers;

class Amount
{
    public static function isValid($validAmount, $amount): bool
    {
        if (preg_match('/^[1-9]\d*~[1-9]\d*$/', $validAmount)) {
            // 区间
            list($min, $max) = explode('~', $validAmount);
            return $amount >= $min && $amount <= $max;
        } else if (preg_match('/^[1-9]\d*$|^([1-9]\d*,)+[1-9]\d*$/', $validAmount)) {
            // 固定
            $amounts = explode(',', $validAmount);
            return in_array($amount, $amounts);
        }
        return false;
    }
}
