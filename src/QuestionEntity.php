<?php

class QuestionEntity
{
    private $id;
    private $content;
    private $timestamp;
    /**
     * @var array
     */
    private $answers;

    /**
     * QuestionEntity constructor.
     * @param $id
     * @param $content
     * @param $timestamp
     * @param array $answers
     */
    public function __construct($id, $content, $timestamp, $answers = [])
    {
        $this->id = $id;
        $this->content = $content;
        $this->timestamp = $timestamp;
        $this->answers = $answers;
    }

    public function id():int
    {
        return $this->id;
    }

    public function content():string
    {
        return $this->content;
    }

    public function timestamp():int
    {
        return $this->timestamp;
    }

    /**
     * @return AnswerEntity[]
     */
    public function answers()
    {
        return $this->answers;
    }
}