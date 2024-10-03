<?php

/*
 * This file is part of the FiveLab CiRules package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

declare(strict_types = 1);

namespace FiveLab\Component\CiRules\PhpCs\FiveLab;

/**
 * The list of possible error codes.
 */
final class ErrorCodes
{
    public const MISSED_LINE_AFTER       = 'MissedLineAfter';
    public const MISSED_LINE_BEFORE      = 'MissedLineBefore';
    public const MISSED                  = 'Missed';
    public const WRONG_FORMAT            = 'WrongFormat';
    public const MULTIPLE                = 'Multiple';
    public const PROHIBITED              = 'Prohibited';
    public const UNUSED                  = 'Unused';
    public const MISSED_PARAMETER_TYPE   = 'MissedFunctionParameterType';
    public const MISSED_RETURN_TYPE      = 'MissedFunctionReturnType';
    public const LINE_AFTER_NOT_ALLOWED  = 'LineAfterNotAllowed';
    public const LINE_BEFORE_NOT_ALLOWED = 'LineBeforeNotAllowed';
}
