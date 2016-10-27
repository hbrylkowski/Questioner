<?php
use Domain\Repositories\QuestionRepository;
use Domain\Validators\AnswerValidator;
use Domain\Validators\QuestionValidator;
use Infrastructure\Serializers\QuestionSerializer;
use Infrastructure\Storage\MockStorage;

/**
 * @property QuestionRepository questionRepository
 * @property QuestionSerializer questionSerializer
 */
class Container extends \Slim\Container
{

    public function __get($name)
    {
        switch ($name){
            case "questionRepository":
                return new QuestionRepository(new QuestionValidator(), new AnswerValidator(), new MockStorage());
                break;
            case "questionSerializer":
                return new QuestionSerializer();
                break;
        }
        return parent::__get($name);
    }



}