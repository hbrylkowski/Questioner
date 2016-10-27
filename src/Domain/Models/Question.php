<?php

namespace Domain\Models;

class Question
{

    /**
     * @var string
     */
    private $content;

    /**
     * Question constructor.
     * @param string $content
     */
    public function __construct($content)
    {
        $this->content = $content;
    }


    public function content(): string
    {
        return $this->content;
    }

    public function contentLength(): int
    {
        return mb_strlen($this->content);
    }
}