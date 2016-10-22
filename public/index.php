<?php
use Slim\Http\Request;
use Slim\Http\Response;

require __DIR__ . '/../vendor/autoload.php';

$container = new \Container();
$config = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];
$app = new \Slim\App($config);

$app->get('/questions', function (Request $request, Response $response) use ($container){
    $questions = $container->questionRepository->getAll();
    $serializer = $container->questionSerializer;
    $serializedQuestions = [];
    foreach ($questions as $question) {
        $serializedQuestions[] = $serializer->toArray($question);
    }
    $response = $response->withJson($serializedQuestions);
    return $response;
});

$app->get('/questions/{id}', function (Request $request, Response $response) use ($container){
    try{
        $question = $container->questionRepository->findById($request->getAttribute('id'));
    } catch (\Exceptions\QuestionerException $e){
        throw new \Slim\Exception\NotFoundException($request, $response);
    }
    $serializer = $container->questionSerializer;
    return $response->withJson($serializer->toArray($question));
});


$app->post('/questions', function (Request $request, Response $response) use ($container){
    $body = $request->getParsedBody();
    if(!isset($body['question'])){
        $response = $response->withStatus(400);
        return $response;
    }
    $question = new Question($body['question']);
    try{
        $questionEntity = $container->questionRepository->save($question);
    } catch (\Exceptions\InvalidQuestionException $e){
        return $response->withStatus(400);
    }
    $response = $response->withJson($container->questionSerializer->toArray($questionEntity));
    $response = $response->withStatus(201);
    return $response;
});

$app->post('/answers', function (Request $request, Response $response) use ($container){
    $body = $request->getParsedBody();
    if(!isset($body['answer']) || !isset($body['id_question'])){
        $response = $response->withStatus(400);
        return $response;
    }
    $answer = new Answer($body['answer'], $body['id_question']);
    try{
       $container->questionRepository->addAnswer($answer);
       $questionEntity = $container->questionRepository->findById($body['id_question']);
    } catch (\Exceptions\InvalidAnswerException $e){
        return $response->withStatus(400);
    }
    $response = $response->withJson($container->questionSerializer->toArray($questionEntity));
    $response = $response->withStatus(201);
    return $response;
});

$app->run();
