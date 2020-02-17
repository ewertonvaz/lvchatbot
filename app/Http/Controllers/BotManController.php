<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use App\Conversations\ExampleConversation;
use App\Conversations\primeiraConversa;
use App\Conversations\MinhaConversa;
use Illuminate\Support\Collection;

class BotManController extends Controller
{
    private $contaOi;
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');

        $botman->fallback(function($bot) {
            $bot->reply( $this->fallBackResponse());
        });
        // \Log::info($botman->getUser()->getId());
        //$botman->say('Hello', $botman->getUser()->getId() );
        
        // $botman->on('event', function($payload, $bot) {
	
        // });
        $contaOi = 0;

        $botman->listen();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tinker()
    {
        return view('tinker');
    }

    /**
     * Loaded through routes/botman.php
     * @param  BotMan $bot
     */
    public function startConversation(BotMan $bot)
    {       
        $bot->startConversation(new ExampleConversation());
    }

    public function primeiraConversa(BotMan $bot)
    {       
        $bot->startConversation(new primeiraConversa());
    }

    public function fallBackResponse()
    {
        return Collection::make([
            'Desculpe, não entendi. Poderia repetir, por favor?',
            'Ainda não compreendi, tente de novo, certo?',
            'Peço que repita, pois não consegui entender.',
            'Tente: escolher cor, oi, vamos conversar',
        ])->random();
    }

    /*     
    public function minhaConversa(Botman $bot){
        $bot->startConversation(new MinhaConversa());
    } */


    /**
     * Get the value of contaOi
     */ 
    static function getContaOi()
    {
        return $this->contaOi;
    }

    /**
     * Set the value of contaOi
     *
     * @return  self
     */ 
    public function setContaOi($contaOi)
    {
        $this->contaOi = $contaOi;

        return $this;
    }
}
