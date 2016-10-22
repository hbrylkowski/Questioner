<?php

namespace spec;

use QuestionRepository;
use Exceptions\InvalidQuestionException;
use PhpSpec\ObjectBehavior;

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
        $storage->save($question)->shouldBeCalled();
        $this->save($question);
    }

    function it_should_not_save_valid_question(
        \QuestionValidator $validator,
        \Question $question,
        \QuestionStorageInterface $storage
    ){
        $validator->isValid($question)->willReturn(false);
        $question->contentLength()->willReturn(1);
        $this->beConstructedWith($validator, $storage);
        $storage->save($question)->shouldNotBeCalled();
        $this->shouldThrow(InvalidQuestionException::class)->during('save', [$question]);
    }
}
