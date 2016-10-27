<?php

namespace Domain\Repositories;

use Domain\Models\Answer;
use Domain\Models\Question;
use Domain\Validators\AnswerValidator;
use Domain\Validators\QuestionValidator;
use Exceptions\InvalidAnswerException;
use Infrastructure\Entities\AnswerEntity;
use Infrastructure\Entities\QuestionEntity;
use Infrastructure\Storage\AnswerStorageInterface;
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
    protected $questionStorage;
    /**
     * @var AnswerValidator
     */
    private $answerValidator;
    /**
     * @var AnswerStorageInterface
     */
    private $answerStorage;

    /**
     * QuestionRepository constructor.
     * @param QuestionValidator $validator
     * @param AnswerValidator $answerValidator
     * @param QuestionStorageInterface $questionStorage
     * @param AnswerStorageInterface $answerStorage
     */
    public function __construct(
        QuestionValidator $validator,
        AnswerValidator $answerValidator,
        QuestionStorageInterface $questionStorage,
        AnswerStorageInterface $answerStorage
    ) {
        $this->validator = $validator;
        $this->questionStorage = $questionStorage;
        $this->answerValidator = $answerValidator;
        $this->answerStorage = $answerStorage;
    }

    public function save(Question $question): QuestionEntity
    {
        if (!$this->validator->isValid($question)) {
            throw \Exceptions\InvalidQuestionException::invalidLength($question->contentLength());
        }
        $questionEntity = new QuestionEntity(null, $question->content(), time());
        return $this->questionStorage->add($questionEntity);
    }

    /**
     * @return QuestionEntity[]
     */
    public function getAll(): array
    {
        return $this->questionStorage->getAll();
    }

    public function findById($id): QuestionEntity
    {
        return $this->questionStorage->getById($id);
    }

    public function addAnswer(Answer $answer): AnswerEntity
    {
        if (!$this->answerValidator->isValid($answer)) {
            throw InvalidAnswerException::invalidLength($answer->contentLength());
        }
        if (!$this->questionStorage->questionWithIdExists($answer->questionId())) {
            throw InvalidAnswerException::noSuchQuestion($answer->questionId());
        }
        if ($this->answerStorage->answersCount($answer->questionId()) >= 2) {
            throw InvalidAnswerException::questionAlreadyHasAnswers();
        }

        $answerEntity = new AnswerEntity(null, $answer->questionId(), $answer->content(), time());
        return $this->answerStorage->add($answerEntity);
    }

}