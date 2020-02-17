<?php
use App\Http\Controllers\BotManController;
use BotMan\BotMan\Messages\Attachments\Image;

// \Log::info($botman->getUser()->getId());
// $botman->say('Hello', $botman->getUser()->getId() );

$botman = resolve('botman');

$botman->hears('Oi', function ($bot) {
    $bot->reply('Oi pra você também! 👋');
    // \Log::info(BotManController::getContaOi());
    $bot->receivesImages(function($bot, $images) {
        foreach ($images as $image) {
            $url = $image->getUrl(); // The direct url
            $title = $image->getTitle(); // The title, if available
            $payload = $image->getPayload(); // The original payload
        }
    });  
});

$botman->hears('Vamos conversar', BotManController::class.'@startConversation');
$botman->hears('escolher cor', BotManController::class.'@primeiraConversa');
$botman->hears('minha conversa', BotManController::class.'@minhaConversa');