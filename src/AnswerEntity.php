<?php

class AnswerEntity
{
    private $id;
    private $content;
    private $timestamp;
    private $questionId;

    /**
     * QuestionEntity constructor.
     * @param $id
     * @param $questionId
     * @param $content
     * @param $timestamp
     */
    public function __construct($id, int $questionId, $content, $timestamp)
    {
        $this->id = $id;
        $this->questionId = $questionId;
        $this->content = $content;
        $this->timestamp = $timestamp;
    }

    public function id():int
    {
        return $this->id;
    }

    public function questionId():int
    {
        return $this->questionId;
    }

    public function content():string
    {
        return $this->content;
    }

    public function timestamp():int
    {
        return $this->timestamp;
    }

}