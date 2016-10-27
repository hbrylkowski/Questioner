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
use Infrastructure\Storage\AnswerStorageInterface;
use Infrastructure\Storage\QuestionStorageInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class QuestionRepositorySpec extends ObjectBehavior
{
    function it_is_initializable(
        QuestionValidator $validator,
        AnswerValidator $answerValidator,
        QuestionStorageInterface $questionStorage,
        AnswerStorageInterface $answerStorage
    ) {
        $this->beConstructedWith($validator, $answerValidator, $questionStorage, $answerStorage);
        $this->shouldHaveType(QuestionRepository::class);
    }

    function it_should_save_valid_question(
        QuestionValidator $validator,
        AnswerValidator $answerValidator,
        Question $question,
        QuestionStorageInterface $questionStorage,
        AnswerStorageInterface $answerStorage
    ) {
        $validator->isValid($question)->willReturn(true);
        $questionStorage->questionWithIdExists(10)->willReturn(true);
        $this->beConstructedWith($validator, $answerValidator, $questionStorage, $answerStorage);
        $question->content()->willReturn("smth");
        $questionStorage->add(Argument::type(QuestionEntity::class))->shouldBeCalled();
        $this->save($question)->shouldReturnAnInstanceOf(QuestionEntity::class);
    }

    function it_should_not_save_invalid_question(
        AnswerValidator $answerValidator,
        QuestionValidator $validator,
        Question $question,
        QuestionStorageInterface $questionStorage,
        AnswerStorageInterface $answerStorage
    ) {
        $validator->isValid($question)->willReturn(false);
        $question->contentLength()->willReturn(1);
        $questionStorage->questionWithIdExists(10)->willReturn(true);
        $this->beConstructedWith($validator, $answerValidator, $questionStorage, $answerStorage);;
        $questionStorage->add(Argument::type(QuestionEntity::class))->shouldNotBeCalled();
        $this->shouldThrow(InvalidQuestionException::class)->during('save', [$question]);
    }

    function it_should_save_answer_to_question(
        Answer $answer,
        QuestionStorageInterface $questionStorage,
        AnswerStorageInterface $answerStorage,
        AnswerValidator $answerValidator,
        QuestionValidator $questionValidator
    ) {
        $answerValidator->isValid($answer)->willReturn(true);
        $answer->questionId()->willReturn(10);
        $questionStorage->questionWithIdExists(10)->willReturn(true);
        $answerStorage->answersCount(10)->willReturn(0);
        $answer->content()->willReturn('No idea, have you try google?');
        $this->beConstructedWith($questionValidator, $answerValidator, $questionStorage, $answerStorage);
        $answerStorage->add(Argument::type(AnswerEntity::class))->shouldBeCalled();
        $this->addAnswer($answer)->shouldReturnAnInstanceOf(AnswerEntity::class);
    }

    function it_should_not_save_invalid_answer_to_question(
        Answer $answer,
        QuestionStorageInterface $questionStorage,
        AnswerStorageInterface $answerStorage,
        AnswerValidator $answerValidator,
        QuestionValidator $questionValidator
    ) {
        $answerValidator->isValid($answer)->willReturn(false);
        $answer->contentLength()->willReturn(10);
        $answer->questionId()->willReturn(10);
        $answer->content()->willReturn('No idea, have you try google?');
        $this->beConstructedWith($questionValidator, $answerValidator, $questionStorage, $answerStorage);
        $questionStorage->add(Argument::type(AnswerEntity::class))->shouldNotBeCalled();
        $this->shouldThrow(InvalidAnswerException::class)->during('addAnswer', [$answer]);
    }

    function it_should_not_save_answer_to_nonexisting_question(
        Answer $answer,
        QuestionStorageInterface $questionStorage,
        AnswerStorageInterface $answerStorage,
        AnswerValidator $answerValidator,
        QuestionValidator $questionValidator
    ) {
        $answerValidator->isValid($answer)->willReturn(true);
        $answer->contentLength()->willReturn(10);
        $answer->questionId()->willReturn(10);
        $questionStorage->questionWithIdExists(10)->willReturn(false);
        $answer->content()->willReturn('No idea, have you try google?');
        $this->beConstructedWith($questionValidator, $answerValidator, $questionStorage, $answerStorage);
        $answerStorage->add(Argument::type(AnswerEntity::class))->shouldNotBeCalled();
        $this->shouldThrow(InvalidAnswerException::class)->during('addAnswer', [$answer]);
    }

    function it_should_not_save_answer_to_question_with_two_answers(
        Answer $answer,
        QuestionStorageInterface $questionStorage,
        AnswerStorageInterface $answerStorage,
        AnswerValidator $answerValidator,
        QuestionValidator $questionValidator
    ) {
        $answerValidator->isValid($answer)->willReturn(true);
        $answer->contentLength()->willReturn(10);
        $answer->questionId()->willReturn(10);
        $answer->content()->willReturn('No idea, have you try google?');
        $answerStorage->answersCount(10)->willReturn(2);
        $questionStorage->questionWithIdExists(10)->willReturn(true);
        $this->beConstructedWith($questionValidator, $answerValidator, $questionStorage, $answerStorage);
        $answerStorage->add(Argument::type(AnswerEntity::class))->shouldNotBeCalled();
        $this->shouldThrow(InvalidAnswerException::class)->during('addAnswer', [$answer]);
    }
}
