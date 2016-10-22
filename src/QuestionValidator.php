<?php

class QuestionValidator
{
    const MAX_LENGTH = 5000;

    const MIN_LENGTH = 20;

    public function isValid(Question $question)
    {
        $contentLength = $question->contentLength();
        return $contentLength >= self::MIN_LENGTH && $contentLength <= self::MAX_LENGTH;
    }
}