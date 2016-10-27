<?php

namespace Exceptions;

use Domain\Validators\AnswerValidator;

class InvalidAnswerException extends QuestionerException
{
    const MESSAGE_LENGTH = 'Answer length should be between %s and %s, and it is %s';
    const MESSAGE_NO_QUESTION = 'Question with id: %s does not exist';
    const MESSAGE_TOO_MANY_ANSWERS = 'Question already have two answers';

    public static function invalidLength(int $actualLength): self
    {
        return new self(sprintf(self::MESSAGE_LENGTH, AnswerValidator::MIN_LENGTH, AnswerValidator::MAX_LENGTH,
            $actualLength));
    }

    public static function noSuchQuestion(int $questionId): self
    {
        return new self(sprintf(self::MESSAGE_NO_QUESTION, $questionId));
    }

    public static function questionAlreadyHasAnswers(): self
    {
        return new self(sprintf(self::MESSAGE_TOO_MANY_ANSWERS));
    }
}