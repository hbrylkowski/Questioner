<?php

namespace spec;

use QuestionRepository;
use Exceptions\InvalidQuestionException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class QuestionRepositorySpec extends ObjectBehavior
{
    function it_is_initializable(\QuestionValidator $validator, \QuestionStorageInterface $storage)
    {
        $this->beConstructedWith($validator, $storage);
        $this->shouldHaveType(QuestionRepository::class);
    }

    function it_should_save_valid_question(
        \QuestionValidator $validator,
        \Question $question,
        \QuestionStorageInterface $storage
    ){
        $validator->isValid($question)->willReturn(true);
        $this->beConstructedWith($validator, $storage);
        $question->content()->willReturn("smth");
        $storage->add(Argument::type(\QuestionEntity::class))->shouldBeCalled();
        $this->save($question)->shouldReturnAnInstanceOf(\QuestionEntity::class);
    }

    function it_should_not_save_valid_question(
        \QuestionValidator $validator,
        \Question $question,
        \QuestionStorageInterface $storage
    ){
        $validator->isValid($question)->willReturn(false);
        $question->contentLength()->willReturn(1);
        $this->beConstructedWith($validator, $storage);
        $storage->add(Argument::type(\QuestionEntity::class))->shouldNotBeCalled();
        $this->shouldThrow(InvalidQuestionException::class)->during('save', [$question]);
    }
}
