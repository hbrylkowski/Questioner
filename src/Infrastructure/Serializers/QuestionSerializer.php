<?php

namespace Infrastructure\Serializers;

use Infrastructure\Entities\QuestionEntity;

class QuestionSerializer
{
    public function toArray(QuestionEntity $questionEntity):array
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