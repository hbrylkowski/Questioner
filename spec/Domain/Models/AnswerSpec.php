<?php

namespace spec\Domain\Models;

use Domain\Models\Answer;
use PhpSpec\ObjectBehavior;

class AnswerSpec extends ObjectBehavior
{
    protected $answer = '0123456789012345678901234';

    public function let()
    {
        $answerContent = $this->answer;
        $this->beConstructedWith($answerContent, 1);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Answer::class);
    }

    public function it_should_have_id()
    {
        $this->content()->shouldBe($this->answer);
    }

    public function it_should_return_valid_length()
    {
        $this->contentLength()->shouldBe(25);
    }

    public function it_should_return_valid_length_for_emojis()
    {
        $this->beConstructedWith('💩', 1);
        $this->contentLength()->shouldBe(1);
    }
}
