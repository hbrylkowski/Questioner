<?php

interface QuestionStorageInterface
{
    public function save(Question $question);
    public function getById(int $id);
    public function getAll();

}