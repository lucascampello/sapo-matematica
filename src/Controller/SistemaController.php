<?php

namespace App\Controller;
use App\Entity\Questionario;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class SistemaController extends AbstractController {
    private $session;
    private $professorSessao;

    public function __construct()
    {
        $this->session = new Session();
        $this->professorSessao = $this->session->get("professor");
//        dd($professorSessao);
//        if($professorSessao == null)
//            $this->sairSistema();
//        else if(empty($professorSessao->id))
//            $this->sairSistema();
        dump($this->professorSessao);
    }

    /**
     * @Route("/sistema", name="app_sistema_inicial")
     */
    public function inicialSistema() {
        return $this->render("sistema/inicial.Sistema.twig", [
            "id" => "sistema",
            "titulo" => "Seja Bem Vindo ao SAPO :: Matemática"
        ]);
    }

    /**
     * @Route("/sistema/sair", name="app_sistema_sair")
     */
    public function sairSistema() {
        $this->session->clear();
        return $this->redirectToRoute('app_tela_inicial');
    }

    /**
     * @Route("/sistema/questionario", name="app_sistema_questionario")
     */
    public function inicialQuestionario(Request $request) {
        $retorno = "";
        $form = $this->createFormBuilder()
            ->add('nome', TextType::class, ["label"=>"Título"])
            ->add('dataInicio', DateType::class, ["label" => "Data de Inicio"])
            ->add('dataFim', DateType::class, ["label" => "Data de Encerramento"])
            ->add('conteudoAbordado', TextType::class, ["label" => "Conteudo Abordado"])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $objDB = $this->getDoctrine()->getRepository(Questionario::class);

            $data = $form->getData();
            $questionario = new Questionario();
            $questionario->setNome($data['nome']);
            $questionario->setDataInicio($data['dataInicio']);
            $questionario->setDataFim($data['dataFim']);
            $questionario->setConteudoAbordado($data['conteudoAbordado']);
            $questionario->setHash($data['nome'].$data['conteudoAbordado']);
            //dd($this->professorSessao);
            $questionario->setProfessor($this->professorSessao);

            $buscaQuestionario = $objDB->findOneBy([
                'nome' => $questionario->getNome()
            ]);

            if($buscaQuestionario == null)
            {
                $objDB = $this->getDoctrine()->getManager();
                $objDB->merge($questionario);
                $objDB->flush();

                $retorno = "Questionario ". $data['nome']."(".$questionario->getId().") cadastrado com sucesso!";
            }
            else
                $retorno = "Questionário já existente!";
            //return $this->redirectToRoute('task_success');
        }

        return $this->render("sistema/questionario.Sistema.twig", [
            "id" => "inicial_questionario",
            "retorno" => $retorno,
            "form" => $form->createView(),
            "titulo" => "Cadastrar Questionário"
        ]);
    }
}