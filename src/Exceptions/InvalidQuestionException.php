<?php

namespace Exceptions;

use QuestionValidator;

class InvalidQuestionException extends QuestionerException
{
    const MESSAGE = 'Question length should be between %s and %s, and it is %s';

    public static function invalidLength($actualLength)
    {
        return new self(sprintf(self::MESSAGE, QuestionValidator::MIN_LENGTH, QuestionValidator::MAX_LENGTH, $actualLength));
    }
}