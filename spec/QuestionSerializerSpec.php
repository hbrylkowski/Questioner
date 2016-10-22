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

    function it_should_correctly_map_to_json(\QuestionEntity $question, \AnswerEntity $answer)
    {
        $question->id()->willReturn(10);
        $question->content()->willReturn('Who was the first president of Poland?');
        $question->timestamp()->willReturn(1458312958);
        $answer->id()->willReturn(15);
        $answer->content()->willReturn('Idk google it');
        $answer->timestamp()->willReturn(1458312959);
        $question->answers()->willReturn([$answer]);
        $this->toArray($question)->shouldReturn(
            [
                'id' => 10,
                'content' => 'Who was the first president of Poland?',
                'createdAt' => 1458312958,
                'answers' => [
                    [
                        'id' => 15,
                        'content' => 'Idk google it',
                        'createdAt' => 1458312959,
                    ]
                ]
            ]
        );
    }
}
