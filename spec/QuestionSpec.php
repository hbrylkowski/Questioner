<?php

namespace spec;

use Question;
use PhpSpec\ObjectBehavior;

class QuestionSpec extends ObjectBehavior
{
    protected $question = '0123456789012345678901234';

    public function let()
    {
        $questionContent = $this->question;
        $this->beConstructedWith($questionContent);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Question::class);
    }

    public function it_should_have_id()
    {
        $this->content()->shouldBe($this->question);
    }

    public function it_should_return_valid_length()
    {
        $this->contentLength()->shouldBe(25);
    }

    public function it_should_return_valid_length_for_emojis()
    {
        $this->beConstructedWith('💩');
        $this->contentLength()->shouldBe(1);
    }
}
