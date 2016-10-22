<?php

class QuestionEntity
{
    private $id;
    private $content;
    private $timestamp;

    /**
     * QuestionEntity constructor.
     * @param $id
     * @param $content
     * @param $timestamp
     */
    public function __construct($id, $content, $timestamp)
    {
        $this->id = $id;
        $this->content = $content;
        $this->timestamp = $timestamp;
    }

    public function getId():int
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





}