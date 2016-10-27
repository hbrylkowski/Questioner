<?php

namespace spec\Domain\Validators;

use Domain\Models\Question;
use Domain\Validators\QuestionValidator;
use PhpSpec\ObjectBehavior;

class QuestionValidatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(QuestionValidator::class);
    }

    //test all the edge cases
    public function it_should_say_invalid_question_when_its_too_short(Question $question)
    {
        $question->contentLength()->willReturn(19);
        $this->isValid($question)->shouldBe(false);
    }

    public function it_should_say_valid_question_when_its_enough(Question $question)
    {
        $question->contentLength()->willReturn(20);
        $this->isValid($question)->shouldBe(true);
    }

    public function it_should_say_invalid_question_when_its_too_long(Question $question)
    {
        $question->contentLength()->willReturn(5001);
        $this->isValid($question)->shouldBe(false);
    }

    public function it_should_say_invalid_question_when_its_almost_too_long(Question $question)
    {
        $question->contentLength()->willReturn(5000);
        $this->isValid($question)->shouldBe(true);
    }
}
