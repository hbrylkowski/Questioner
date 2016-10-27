<?php
use Domain\Models\Answer;
use Domain\Models\Question;
use Slim\Http\Request;
use Slim\Http\Response;

require __DIR__ . '/../vendor/autoload.php';

$config = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];
$container = new \Container($config);
$app = new \Slim\App($container);

$app->get('/questions', function (Request $request, Response $response){
    $questions = $this->questionRepository->getAll();
    $serializer = $this->questionSerializer;
    $serializedQuestions = [];
    foreach ($questions as $question) {
        $serializedQuestions[] = $serializer->toArray($question);
    }
    $response = $response->withJson($serializedQuestions);
    return $response;
});

$app->get('/questions/{id}', function (Request $request, Response $response){
    try{
        $question = $this->questionRepository->findById($request->getAttribute('id'));
    } catch (\Exceptions\QuestionerException $e){
        throw new \Slim\Exception\NotFoundException($request, $response);
    }
    $serializer = $this->questionSerializer;
    return $response->withJson($serializer->toArray($question));
});


$app->post('/questions', function (Request $request, Response $response){
    $body = $request->getParsedBody();
    if(!isset($body['question'])){
        $response = $response->withStatus(400);
        return $response;
    }
    $question = new Question($body['question']);
    try{
        $questionEntity = $this->questionRepository->save($question);
    } catch (\Exceptions\InvalidQuestionException $e){
        return $response->withStatus(400);
    }
    $response = $response->withJson($this->questionSerializer->toArray($questionEntity));
    $response = $response->withStatus(201);
    return $response;
});

$app->post('/answers', function (Request $request, Response $response){
    $body = $request->getParsedBody();
    if(!isset($body['answer']) || !isset($body['id_question'])){
        $response = $response->withStatus(400);
        return $response;
    }
    $answer = new Answer($body['answer'], $body['id_question']);
    try{
        $this->questionRepository->addAnswer($answer);
       $questionEntity = $this->questionRepository->findById($body['id_question']);
    } catch (\Exceptions\InvalidAnswerException $e){
        return $response->withStatus(400);
    }
    $response = $response->withJson($this->questionSerializer->toArray($questionEntity));
    $response = $response->withStatus(201);
    return $response;
});

$app->run();
