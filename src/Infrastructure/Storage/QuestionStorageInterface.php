<?php

namespace Infrastructure\Storage;

use Infrastructure\Entities\AnswerEntity;
use Infrastructure\Entities\QuestionEntity;

interface QuestionStorageInterface
{
    public function add(QuestionEntity $question): QuestionEntity;

    public function getById(int $id): QuestionEntity;

    /**
     * @return QuestionEntity[]
     */
    public function getAll(): array;

    public function addAnswer(AnswerEntity $answerEntity): AnswerEntity;

    public function questionWithIdExists($questionId): bool;

    public function answersCount($questionId): int;

}