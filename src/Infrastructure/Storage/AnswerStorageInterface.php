<?php

namespace Infrastructure\Storage;

use Infrastructure\Entities\AnswerEntity;

interface AnswerStorageInterface
{
    public function add(AnswerEntity $answerEntity): AnswerEntity;

    public function answersCount($questionId): int;

}