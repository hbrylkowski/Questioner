<?php

class QuestionSerializer
{
    public function toArray(\QuestionEntity $questionEntity)
    {
        $answers = [];
        foreach ($questionEntity->answers() as $answer) {
            $answers[] = [
                'id' => $answer->id(),
                'content' => $answer->content(),
                'createdAt' => $answer->timestamp(),
            ];
        }
        return [
            'id' => $questionEntity->id(),
            'content' => $questionEntity->content(),
            'createdAt' => $questionEntity->timestamp(),
            'answers' => $answers,
        ];
    }
}