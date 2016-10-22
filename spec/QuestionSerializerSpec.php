<?php

namespace spec;

use QuestionSerializer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class QuestionSerializerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(QuestionSerializer::class);
    }

    function it_should_correctly_map_to_json(\QuestionEntity $question)
    {
        $question->id()->willReturn(10);
        $question->content()->willReturn('Who was the first president of Poland?');
        $question->timestamp()->willReturn(1458312958);
        $this->toArray($question)->shouldReturn(
            [
                'id' => 10,
                'content' => 'Who was the first president of Poland?',
                'createdAt' => 1458312958,
            ]
        );
    }
}
