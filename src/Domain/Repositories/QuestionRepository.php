<?php

namespace Domain\Repositories;

use Domain\Models\Answer;
use Domain\Models\Question;
use Domain\Validators\AnswerValidator;
use Domain\Validators\QuestionValidator;
use Exceptions\InvalidAnswerException;
use Infrastructure\Entities\AnswerEntity;
use Infrastructure\Entities\QuestionEntity;
use Infrastructure\Storage\QuestionStorageInterface;

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
     * @var AnswerValidator
     */
    private $answerValidator;

    /**
     * QuestionRepository constructor.
     * @param QuestionValidator $validator
     * @param AnswerValidator $answerValidator
     * @param QuestionStorageInterface $storage
     */
    public function __construct(QuestionValidator $validator, AnswerValidator $answerValidator, QuestionStorageInterface $storage)
    {
        $this->validator = $validator;
        $this->storage = $storage;
        $this->answerValidator = $answerValidator;
    }

    public function save(Question $question)
    {
        if(!$this->validator->isValid($question))
            throw \Exceptions\InvalidQuestionException::invalidLength($question->contentLength());
        $questionEntity = new QuestionEntity(null, $question->content(), time());
        return $this->storage->add($questionEntity);
    }

    public function getAll()
    {
        return $this->storage->getAll();
    }

    public function findById($id)
    {
        return $this->storage->getById($id);
    }

    public function addAnswer(Answer $answer)
    {
        if(!$this->answerValidator->isValid($answer))
            throw InvalidAnswerException::invalidLength($answer->contentLength());
        if(!$this->storage->questionWithIdExists($answer->questionId()))
            throw InvalidAnswerException::noSuchQuestion($answer->questionId());
        if($this->storage->answersCount($answer->questionId()) >= 2)
            throw InvalidAnswerException::questionAlreadyHasAnswers();

        $answerEntity = new AnswerEntity(null, $answer->questionId(), $answer->content(), time());
        return $this->storage->addAnswer($answerEntity);
    }

}