<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest as IlluminateFormRequest;

abstract class FormRequest extends IlluminateFormRequest
{
    protected int $signedTinyIntMin = -128;
    protected int $signedTinyIntMax = 127;
    protected int $unsignedTinyIntMax = 255;
    protected int $signedSmallIntMin = -32768;
    protected int $signedSmallIntMax = 32767;
    protected int $unsignedSmallIntMax = 65535;
    protected int $signedMediumIntMin = -8388608;
    protected int $signedMediumIntMax = 8388607;
    protected int $unsignedMediumIntMax = 16777215;
    protected int $signedIntMin = -2147483648;
    protected int $signedIntMax = 2147483647;
    protected int $unsignedIntMax = 4294967295;
    protected string $signedBigIntMin = '-9223372036854775808';
    protected string $signedBigIntMax = '9223372036854775807';
    protected string $unsignedBigIntMax = '18446744073709551615';
}
