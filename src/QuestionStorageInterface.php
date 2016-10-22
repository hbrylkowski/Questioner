<?php

interface QuestionStorageInterface
{
    public function add(QuestionEntity $question):QuestionEntity;
    public function getById(int $id):QuestionEntity;

    /**
     * @return QuestionEntity[]
     */
    public function getAll();

}