<?php

class RestApiTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    public function setUp()
    {
        $this->client = new GuzzleHttp\Client();
    }

    public function testGetAll()
    {
        $response = $this->client->get('http://localhost/questions');

        $this->assertEquals(200, $response->getStatusCode());
        $dataRetrieved = json_decode($response->getBody(), true);
        $sampleQuestion = $dataRetrieved[0];
        $this->assertArrayHasKey('id', $sampleQuestion);
        $this->assertArrayHasKey('content', $sampleQuestion);
        $this->assertArrayHasKey('createdAt', $sampleQuestion);
    }

    public function testGetOneExisting()
    {
        $response = $this->client->get('http://localhost/questions/1');

        $this->assertEquals(200, $response->getStatusCode());
        $sampleQuestion = json_decode($response->getBody(), true);
        $this->assertArrayHasKey('id', $sampleQuestion);
        $this->assertArrayHasKey('content', $sampleQuestion);
        $this->assertArrayHasKey('createdAt', $sampleQuestion);
        $this->assertArrayHasKey('answers', $sampleQuestion);
    }

    public function testGetNonExisting()
    {
        $response = $this->client->get('http://localhost/questions/404', ['exceptions' => false]);
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testCreateValidQuestion()
    {
        $questionContent = 'Who was the first president of Poland?';
        $response = $this->client->post('http://localhost/questions', [
                'json' => ['question' => $questionContent],
                'exceptions' => false
            ]
        );
        $this->assertEquals(201, $response->getStatusCode());

        $sampleQuestion = json_decode($response->getBody(), true);
        $this->assertArrayHasKey('id', $sampleQuestion);
        $this->assertArrayHasKey('content', $sampleQuestion);
        $this->assertEquals($questionContent, $sampleQuestion['content']);
        $this->assertArrayHasKey('createdAt', $sampleQuestion);
    }

    public function testCreateInvalidQuestion()
    {
        $questionContent = 'a';
        $response = $this->client->post('http://localhost/questions', [
                'json' => ['question' => $questionContent],
                'exceptions' => false
            ]
        );
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testCreateValidAnswer()
    {
        $answer = 'No idea, have you try google?';
        $idQuestion = 2;
        $response = $this->client->post('http://localhost/answers', [
                'json' => [
                    'answer' => $answer,
                    'id_question' => $idQuestion,
                ],
                'exceptions' => false,
            ]
        );
        $this->assertEquals(201, $response->getStatusCode());

        $question = json_decode($response->getBody(), true);
        $sampleAnswer = $question['answers'][0];
        $this->assertArrayHasKey('id', $sampleAnswer);
        $this->assertArrayHasKey('content', $sampleAnswer);
        $this->assertArrayHasKey('createdAt', $sampleAnswer);
    }

    public function testCreateInvalidAnswer()
    {
        $answer = 'a';
        $idQuestion = 2;
        $response = $this->client->post('http://localhost/answers', [
                'json' => [
                    'answer' => $answer,
                    'id_question' => $idQuestion,
                ],
                'exceptions' => false,
            ]
        );
        $this->assertEquals(400, $response->getStatusCode());
    }
}
