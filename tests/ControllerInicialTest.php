<?php

namespace App\Tests;

use Symfony\Component\Panther\PantherTestCase;
use Symfony\Component\Panther\Client;


class ControllerInicialTest extends PantherTestCase
{
    private $cliente;
    private $requisicao;

    private function start()
    {
        $this->cliente = static::createPantherClient(['browser' => static::FIREFOX]);
        $this->requisicao = $this->cliente->request('GET', 'http://127.0.0.1:8001'); 
        sleep(1);
    }

    /**
     * @test
     */
    public function testeLoginCorreto(): void
    {
        // PREPARAÇÃO
        $this->start();
        $requisicaoLink = $this->acessarTelaInicial(0); // 1° Link = Login

        // CONFIGURAÇÃO
        $formulario = $requisicaoLink->filter('form')->form([
            "form[email]" => 'lucas.campello@gmail.com',
            "form[pwd]" => '123123'
        ]);

        sleep(1);
        // EXECUÇÃO
        $this->cliente->submit($formulario);

        // TESTE (Acessou a tela de Sistema)
        $this->assertSame('/sistema', substr($this->cliente->getCurrentURL(),-8));
    }


    /**
     * @test
     */
    public function testeLoginIncorreto(): void
    {
        // PREPARAÇÃO
        $this->start();
        $requisicaoLink = $this->acessarTelaInicial(0); // 1° Link = Login

        // CONFIGURAÇÃO
        $formulario = $requisicaoLink->filter('form')->form([
            "form[email]" => 'lucas.campello@gmail.com',
            "form[pwd]" => '111'
        ]);

        sleep(1);
        // EXECUÇÃO
        $this->cliente->submit($formulario);

        // TESTE (Permaneceu na Tela de Login)
        $this->assertSame('/login', substr($this->cliente->getCurrentURL(),-6));
    }

    private function acessarTelaInicial(int $link)
    {
        // CARREGA O PRIMEIRO LINK
        $link = $this->requisicao->filter('a')->eq($link)->attr('href');
        // EXECUTA A REQUISIÇÃO
        return $this->cliente->request('GET',$link);
    }
}
