<?php

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
                return new QuestionRepository(new QuestionValidator(), new MockStorage());
                break;
            case "questionSerializer":
                return new QuestionSerializer();
                break;
        }
        return parent::__get($name);
    }



}