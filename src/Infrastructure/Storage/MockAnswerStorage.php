<?php

namespace Infrastructure\Storage;


use Infrastructure\Entities\AnswerEntity;

class MockAnswerStorage implements AnswerStorageInterface
{

    public function add(AnswerEntity $answerEntity): AnswerEntity
    {
        return new AnswerEntity(
            rand(1, 60),
            $answerEntity->questionId(),
            $answerEntity->content(),
            1458302958
        );
    }

    public function answersCount($questionId): int
    {
        if ($questionId === 1) {
            return 2;
        }
        if ($questionId === 2) {
            return 1;
        }
        return rand(0, 2);
    }
}