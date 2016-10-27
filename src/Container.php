<?php
use Domain\Repositories\QuestionRepository;
use Domain\Validators\AnswerValidator;
use Domain\Validators\QuestionValidator;
use Infrastructure\Serializers\QuestionSerializer;
use Infrastructure\Storage\MockAnswerStorage;
use Infrastructure\Storage\MockQuestionStorage;

/**
 * @property QuestionRepository questionRepository
 * @property QuestionSerializer questionSerializer
 */
class Container extends \Slim\Container
{

    public function __get($name)
    {
        switch ($name) {
            case "questionRepository":
                return new QuestionRepository(
                    new QuestionValidator(),
                    new AnswerValidator(),
                    new MockQuestionStorage(),
                    new MockAnswerStorage()
                );
                break;
            case "questionSerializer":
                return new QuestionSerializer();
                break;
        }
        return parent::__get($name);
    }


}