<?php

namespace spec;

use PhpSpec\ObjectBehavior;

class AnswerValidator extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AnswerValidator::class);
    }

    //test all the edge cases
    public function it_should_say_invalid_question_when_its_too_short(\Answer $answer)
    {
        $answer->contentLength()->willReturn(19);
        $this->isValid($answer)->shouldBe(false);
    }

    public function it_should_say_valid_question_when_its_enough(\Answer $answer)
    {
        $answer->contentLength()->willReturn(20);
        $this->isValid($answer)->shouldBe(true);
    }

    public function it_should_say_invalid_question_when_its_too_long(\Answer $answer)
    {
        $answer->contentLength()->willReturn(5001);
        $this->isValid($answer)->shouldBe(false);
    }

    public function it_should_say_invalid_question_when_its_almost_too_long(\Answer $answer)
    {
        $answer->contentLength()->willReturn(5000);
        $this->isValid($answer)->shouldBe(true);
    }
}
