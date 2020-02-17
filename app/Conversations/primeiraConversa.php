<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

class primeiraConversa extends Conversation
{
    /**
     * Primeira question
     */

    public function perguntar()
    {
        $question = Question::create("Qual COR você prefere?")
            ->addButtons([
                Button::create('VERMELHO')->value('red'),
                Button::create('AZUL')->value('blue'),
            ]);
        
        return $this->ask($question, function (Answer $answer) {
            
             if ($answer->isInteractiveMessageReply()) {
                $this->say("A psicologia das cores diz que:");
                $this->getBot()->typesAndWaits(3);
                if ($answer->getValue() === 'red') {
                    $attachment = new Image('/img/flor-vermelha.jpg');
                    $this->say("Você é dinâmico(a) e forte!");
                } else {
                    $attachment = new Image('/img/flor-azul.jpg');
                    $this->say("Você é confiável e amigável!");
                }
            }
            $message = OutgoingMessage::create('Receba nossas boas vindas e aceite  esta flor como prova de amizade')
                ->withAttachment($attachment);
            $this->getBot()->reply($message);
        });
    }

    /**
     * Iniciar conversação
     */
    public function run()
    {
        $this->perguntar();
    }
}