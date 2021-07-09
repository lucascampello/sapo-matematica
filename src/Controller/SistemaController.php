<?php

namespace App\Controller;
use App\Entity\Questionario;
use App\Entity\Questao;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SistemaController extends AbstractController {
    private $session;
    private $professorSessao;

    public function __construct()
    {
        $this->session = new Session();
        $this->professorSessao = $this->session->get("professor");
    }

    /**
     * Tela inicial do Sistema
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
     * @Route("/sistema/questionario", name="app_questionario_menu")
     */
    public function inicialQuestionario(Request $request) {

        return $this->render("sistema/questionario.Menu.twig", [
            "id" => "inicial_questionario",
            "titulo" => "Menu - Questionário"
        ]);
    }

    /**
     * @Route("/sistema/questionario/insert", name="app_questionario_insert")
     */
    public function insertQuestionario(Request $request) {
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

        return $this->render("sistema/questionario.Insert.twig", [
            "id" => "insert_questionario",
            "retorno" => $retorno,
            "form" => $form->createView(),
            "titulo" => "Cadastrar Questionário"
        ]);
    }

    /**
     * @Route("/sistema/questao/insert", name="app_questao_insert")
     */
    public function insertQuestao(Request $request)
    {
        $retorno = "";

        $form = $this->createFormBuilder()
            ->add('questionario', EntityType::class, ['class' => Questionario::class])
            ->add('titulo', TextType::class, ["label"=>"Título"])
            ->add('descricao', TextareaType::class, ["label" => "Descricao"])
            ->add('resultado', TextType::class, ["label" => "Resultado"])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $objDB = $this->getDoctrine()->getRepository(Questionario::class);
            $data = $form->getData();
            $questao = new Questao();
            $questao->setQuestionario($data["questionario"]);
            $questao->setDescricao($data["descricao"]);
            $questao->setTitulo($data["titulo"]);
            $questao->setResultado($data["resultado"]);

            $objDB = $this->getDoctrine()->getManager();
            $objDB->merge($questao);
            $objDB->flush();

            $retorno = "Questão ". $data['titulo']." cadastrado com sucesso!";
        }
        

        return $this->render("sistema/questao.Insert.twig", [
            "id" => "insert_questao",
            "retorno" => $retorno,
            "form" => $form->createView(),
            "titulo" => "Cadastrar Questao"
        ]);
    }
}