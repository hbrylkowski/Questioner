<?php

class QuestionValidator
{
    const MAX_LENGTH = 5000;

    const MIN_LENGTH = 19;

    public function isValid(Question $question)
    {
        $contentLength = $question->contentLength();
        return $contentLength > self::MIN_LENGTH && $contentLength <= self::MAX_LENGTH;
    }
}