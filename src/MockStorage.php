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
        // TODO: Implement getAll() method.
    }
}