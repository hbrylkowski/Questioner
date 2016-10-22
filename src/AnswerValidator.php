<?php

class AnswerValidator
{
    const MAX_LENGTH = 5000;

    const MIN_LENGTH = 20;

    public function isValid(Answer $answer)
    {
        $contentLength = $answer->contentLength();
        return $contentLength >= self::MIN_LENGTH && $contentLength <= self::MAX_LENGTH;
    }
}