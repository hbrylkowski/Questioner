<?php

namespace Infrastructure\Entities;

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
    public function __construct($id, string $content, int $timestamp, array $answers = [])
    {
        $this->id = $id;
        $this->content = $content;
        $this->timestamp = $timestamp;
        $this->answers = $answers;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function timestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @return AnswerEntity[]
     */
    public function answers(): array
    {
        return $this->answers;
    }
}