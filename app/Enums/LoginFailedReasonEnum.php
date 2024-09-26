<?php

namespace App\Enums;

enum LoginFailedReasonEnum: string
{
    case USERNAME_NOT_FOUND = 'USERNAME_NOT_FOUND';
    case PASSWORD_INCORRECT = 'PASSWORD_INCORRECT';
    case TFA_CODE_INCORRECT = 'TFA_CODE_INCORRECT';
    case IP_NOT_ALLOWED = 'IP_NOT_ALLOWED';
}
