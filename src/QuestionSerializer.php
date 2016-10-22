<?php

class QuestionSerializer
{
    public function toArray(\QuestionEntity $questionEntity)
    {
        return [
            'id' => $questionEntity->id(),
            'content' => $questionEntity->content(),
            'createdAt' => $questionEntity->timestamp(),
        ];
    }
}