<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Conversations\Conversation;
use App\Questions\FormQuestion;
use App\Questions\TextAction;

class MinhaConversa extends Conversation
{
    /**
     * First question
     */
    public function askReason()
    {
        $question = FormQuestion::create("Vamos lá, o que deseja?")
            ->fallback('Unable to ask question')
            ->callbackId('ask_reason')
            ->addText(TextAction::create('Digite seu nome')->value('nome'))
            ->addButtons([
                Button::create('Conte uma piada')->value('joke'),
                Button::create('Quero motivação')->value('quote'),
            ]);

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() === 'joke') {
                    $joke = json_decode(file_get_contents('http://api.icndb.com/jokes/random'));
                    $this->say($joke->value->joke);
                } else {
                    $this->say(Inspiring::quote());
                }
            }
        });
    }

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->askReason();
    }
}
