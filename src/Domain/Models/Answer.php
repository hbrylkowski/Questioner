<?php

namespace Domain\Models;

class Answer
{
    private $content;
    private $questionId;

    /**
     * Answer constructor.
     * @param $content
     * @param $questionId
     */
    public function __construct($content, $questionId)
    {
        $this->content = $content;
        $this->questionId = $questionId;
    }

    /**
     * @return mixed
     */
    public function content():string
    {
        return $this->content;
    }

    /**
     * @return mixed
     */
    public function questionId(): int
    {
        return $this->questionId;
    }

    public function contentLength(): int
    {
        return mb_strlen($this->content);
    }

}