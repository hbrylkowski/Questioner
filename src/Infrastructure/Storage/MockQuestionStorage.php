<?php

namespace Infrastructure\Storage;

use Exceptions\QuestionNotFound;
use Infrastructure\Entities\AnswerEntity;
use Infrastructure\Entities\QuestionEntity;

class MockQuestionStorage implements QuestionStorageInterface
{

    public function add(QuestionEntity $question): QuestionEntity
    {
        return new QuestionEntity(
            rand(0, 200),
            $question->content(),
            $question->timestamp()
        );
    }

    public function getById(int $id): QuestionEntity
    {
        if ($id === 404) {
            throw new QuestionNotFound();
        }

        return new QuestionEntity(
            rand(0, 200),
            "Who was the first president of Poland?",
            1458312958,
            [
                new AnswerEntity(2, 1, 'I don\'t know google it or something.', 1458312958),
            ]
        );
    }

    /**
     * @return QuestionEntity[]
     */
    public function getAll(): array
    {
        return [
            new QuestionEntity(
                1,
                "Who was the first president of Poland?",
                1458312958,
                [
                    new AnswerEntity(1, 1, 'I don\'t know google it or something.', 1458312958),
                    new AnswerEntity(2, 1, 'I don\'t know google it or something.', 1458312958),
                ]
            ),
            new QuestionEntity(
                2,
                "Who was the last president of Poland?",
                1458302958
            ),
        ];
    }


    public function questionWithIdExists($questionId): bool
    {
        return in_array($questionId, [1, 2]);
    }

}