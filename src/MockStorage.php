<?php

class MockStorage implements QuestionStorageInterface
{

    public function add(QuestionEntity $question):QuestionEntity
    {
        return new QuestionEntity(
            rand(0,200),
            $question->content(),
            $question->timestamp()
        );
    }

    public function getById(int $id): QuestionEntity
    {
        if($id === 404){
            throw new \Exceptions\QuestionNotFound();
        }

        return new QuestionEntity(
            rand(0,200),
            "Who was the first president of Poland?",
            1458312958
        );
    }

    /**
     * @return QuestionEntity[]
     */
    public function getAll()
    {
        return [
            new QuestionEntity(
                rand(0,200),
                "Who was the first president of Poland?",
                1458312958
            ),
            new QuestionEntity(
                rand(201,400),
                "Who was the last president of Poland?",
                1458302958
            ),
        ];
    }

    public function addAnswer(AnswerEntity $answerEntity): AnswerEntity
    {
        return new AnswerEntity(
            rand(1,60),
            $answerEntity->questionId(),
            $answerEntity->content(),
            1458302958
        );
    }

    public function questionWithIdExists($questionId): bool
    {
        // TODO: Implement questionWithIdExists() method.
    }

    public function answersCount($questionId): int
    {
        // TODO: Implement answersCount() method.
    }
}