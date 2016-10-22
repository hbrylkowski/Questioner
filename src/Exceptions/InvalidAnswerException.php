<?php

namespace Exceptions;

use AnswerValidator;

class InvalidAnswerException extends QuestionerException
{
    const MESSAGE_LENGTH = 'Answer length should be between %s and %s, and it is %s';
    const MESSAGE_NO_QUESTION = 'Question with id: %s does not exist';
    const MESSAGE_TOO_MANY_ANSWERS = 'Question already have two answers';

    public static function invalidLength($actualLength)
    {
        return new self(sprintf(self::MESSAGE_LENGTH, AnswerValidator::MIN_LENGTH, AnswerValidator::MAX_LENGTH, $actualLength));
    }

    public static function noSuchQuestion($questionId)
    {
        return new self(sprintf(self::MESSAGE_NO_QUESTION, $questionId));
    }

    public static function questionAlreadyHasAnswers()
    {
        return new self(sprintf(self::MESSAGE_TOO_MANY_ANSWERS));
    }
}