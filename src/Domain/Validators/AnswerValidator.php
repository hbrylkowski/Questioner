<?php

namespace Domain\Validators;

use Domain\Models\Answer;

class AnswerValidator
{
    const MAX_LENGTH = 5000;

    const MIN_LENGTH = 20;

    public function isValid(Answer $answer): bool
    {
        $contentLength = $answer->contentLength();
        return $contentLength >= self::MIN_LENGTH && $contentLength <= self::MAX_LENGTH;
    }
}