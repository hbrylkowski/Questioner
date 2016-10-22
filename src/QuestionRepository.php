<?php

class QuestionRepository
{
    /**
     * @var QuestionValidator
     */
    protected $validator;
    /**
     * @var QuestionStorageInterface
     */
    protected $storage;

    /**
     * QuestionRepository constructor.
     * @param QuestionValidator $validator
     * @param QuestionStorageInterface $storage
     */
    public function __construct(QuestionValidator $validator, QuestionStorageInterface $storage)
    {
        $this->validator = $validator;
        $this->storage = $storage;
    }

    public function save(Question $question)
    {
        if(!$this->validator->isValid($question))
            throw \Exceptions\InvalidQuestionException::invalidLength($question->contentLength());
        $this->storage->save($question);
    }
}