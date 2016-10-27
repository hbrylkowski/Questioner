<?php

namespace spec\Domain\Repositories;

use Domain\Models\Answer;
use Domain\Models\Question;
use Domain\Repositories\QuestionRepository;
use Domain\Validators\AnswerValidator;
use Domain\Validators\QuestionValidator;
use Exceptions\InvalidAnswerException;
use Exceptions\InvalidQuestionException;
use Infrastructure\Entities\AnswerEntity;
use Infrastructure\Entities\QuestionEntity;
use Infrastructure\Storage\QuestionStorageInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class QuestionRepositorySpec extends ObjectBehavior
{
    function it_is_initializable(
        QuestionValidator $validator,
        AnswerValidator $answerValidator,
        QuestionStorageInterface $storage
    ){
        $this->beConstructedWith($validator, $answerValidator, $storage);
        $this->shouldHaveType(QuestionRepository::class);
    }

    function it_should_save_valid_question(
        QuestionValidator $validator,
        AnswerValidator $answerValidator,
        Question $question,
        QuestionStorageInterface $storage
    ){
        $validator->isValid($question)->willReturn(true);
        $storage->questionWithIdExists(10)->willReturn(true);
        $this->beConstructedWith($validator, $answerValidator, $storage);
        $question->content()->willReturn("smth");
        $storage->add(Argument::type(QuestionEntity::class))->shouldBeCalled();
        $this->save($question)->shouldReturnAnInstanceOf(QuestionEntity::class);
    }

    function it_should_not_save_invalid_question(
        AnswerValidator $answerValidator,
        QuestionValidator $validator,
        Question $question,
        QuestionStorageInterface $storage
    ){
        $validator->isValid($question)->willReturn(false);
        $question->contentLength()->willReturn(1);
        $storage->questionWithIdExists(10)->willReturn(true);
        $this->beConstructedWith($validator, $answerValidator, $storage);
        $storage->add(Argument::type(QuestionEntity::class))->shouldNotBeCalled();
        $this->shouldThrow(InvalidQuestionException::class)->during('save', [$question]);
    }

    function it_should_save_answer_to_question(
        Answer $answer,
        QuestionStorageInterface $storage,
        AnswerValidator $answerValidator,
        QuestionValidator $questionValidator
    )
    {
        $answerValidator->isValid($answer)->willReturn(true);
        $answer->questionId()->willReturn(10);
        $storage->questionWithIdExists(10)->willReturn(true);
        $storage->answersCount(10)->willReturn(0);
        $answer->content()->willReturn('No idea, have you try google?');
        $this->beConstructedWith($questionValidator, $answerValidator, $storage);
        $storage->addAnswer(Argument::type(AnswerEntity::class))->shouldBeCalled();
        $this->addAnswer($answer)->shouldReturnAnInstanceOf(AnswerEntity::class);
    }

    function it_should_not_save_invalid_answer_to_question(
        Answer $answer,
        QuestionStorageInterface $storage,
        AnswerValidator $answerValidator,
        QuestionValidator $questionValidator
    )
    {
        $answerValidator->isValid($answer)->willReturn(false);
        $answer->contentLength()->willReturn(10);
        $answer->questionId()->willReturn(10);
        $answer->content()->willReturn('No idea, have you try google?');
        $this->beConstructedWith($questionValidator, $answerValidator, $storage);
        $storage->addAnswer(Argument::type(AnswerEntity::class))->shouldNotBeCalled();
        $this->shouldThrow(InvalidAnswerException::class)->during('addAnswer', [$answer]);
    }

    function it_should_not_save_answer_to_nonexisting_question(
        Answer $answer,
        QuestionStorageInterface $storage,
        AnswerValidator $answerValidator,
        QuestionValidator $questionValidator
    )
    {
        $answerValidator->isValid($answer)->willReturn(true);
        $answer->contentLength()->willReturn(10);
        $answer->questionId()->willReturn(10);
        $storage->questionWithIdExists(10)->willReturn(false);
        $answer->content()->willReturn('No idea, have you try google?');
        $this->beConstructedWith($questionValidator, $answerValidator, $storage);
        $storage->addAnswer(Argument::type(AnswerEntity::class))->shouldNotBeCalled();
        $this->shouldThrow(InvalidAnswerException::class)->during('addAnswer', [$answer]);
    }

    function it_should_not_save_answer_to_question_with_two_answers(
        Answer $answer,
        QuestionStorageInterface $storage,
        AnswerValidator $answerValidator,
        QuestionValidator $questionValidator
    )
    {
        $answerValidator->isValid($answer)->willReturn(true);
        $answer->contentLength()->willReturn(10);
        $answer->questionId()->willReturn(10);
        $answer->content()->willReturn('No idea, have you try google?');
        $storage->answersCount(10)->willReturn(2);
        $storage->questionWithIdExists(10)->willReturn(true);
        $this->beConstructedWith($questionValidator, $answerValidator, $storage);
        $storage->addAnswer(Argument::type(AnswerEntity::class))->shouldNotBeCalled();
        $this->shouldThrow(InvalidAnswerException::class)->during('addAnswer', [$answer]);
    }
}
