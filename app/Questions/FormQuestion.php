<?php

namespace App\Questions;

use BotMan\BotMan\Messages\Outgoing\Question;
use App\Questions\TextAction;

class FormQuestion extends Question
{
    public function addText(TextAction $text)
    {
        $this->actions[] = $text->toArray();

        return $this;
    }

    public function addTexts(array $texts)
    {
        foreach ($texts as $text) {
            $this->actions[] = $text->toArray();
        }

        return $this;
    }
}