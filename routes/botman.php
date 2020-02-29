<?php
use App\Http\Controllers\BotManController;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Middleware\ApiAi;
use App\Http\Middleware\DialogflowV2;

$botman = resolve('botman');
//$dialogflow = ApiAi::create(env('DIALOG_FLOW_TOKEN'))->listenForAction();
$dialogflow = DialogflowV2::create('pt-BR')->listenForAction();
$botman->middleware->received($dialogflow);

// $botman->say('Hello', $botman->getUser()->getId() );

$botman->hears('(Oi|Olá|Salve)', function ($bot, $saudacao) {
    $bot->reply($saudacao.' pra você também! 👋'); 
});

$botman->hears('Vamos conversar', BotManController::class.'@startConversation');

//$botman->hears('escolher cor', BotManController::class.'@primeiraConversa');
$botman->hears('.*cor$', BotManController::class.'@primeiraConversa');

$botman->hears('Meu nome é {nome} tenho {idade} anos', function ($bot, $nome, $idade) {
    $bot->reply('Como vai '.$nome.', então você nasceu em '.(Date('Y')-$idade));
});

$botman->hears('(^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$)', function ($bot, $email) {
    $bot->reply('Entedi, enviarei a mensagem para seu endereço de email : ' . $email);
});

// Alguns experimentos usando Regex
$botman->hears('I want ([0-9]+) portions of (Cheese|Cake)', function ($bot, $amount, $dish) {
    $bot->reply('You will get '.$amount.' portions of '.$dish.' served shortly.');
});

/* $botman->hears('botman.agent.menu', function ($bot) {
    $extras = $bot->getMessage()->getExtras();
    $apiReply = $extras['apiReply'];
    $apiAction = $extras['apiAction'];
    $apiIntent = $extras['apiIntent'];
    
    $bot->reply($apiReply);
})->middleware($dialogflow); */

$botman->fallback(function($bot) {
    //return $bot->reply('Desculpe, não entendi. Esta é a lista de comandos que eu conheço: \'oi\', \'vamos conversar\'');   
    return $bot->reply($bot->getMessage()->getExtras('apiReply'));
    //return $bot->reply($bot->getMessage()->getExtras('apiIntent'));
});