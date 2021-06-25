<?php

namespace App\Controller;
use App\Entity\Professor;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Session\Session;


class ControllerInicial extends AbstractController{
    
    /**
     * 
     * @Route("/", name="app_tela_inicial")
     */
    public function acessarTelaInicial()
    {
        return $this->render("base/inicial.AcessarTelaInicial.twig", ["titulo" => "Tela Inicial", "id" => "inicial"]);
    }

    /**
     * 
     * @Route("/login", name="app_tela_login")
     */
    public function telaLogin(Request $request)
    {
        $erro = "";
        $form = $this->createFormBuilder()
            ->add('email', TextType::class, ["label"=>"E-mail"])
            ->add('pwd', PasswordType::class, ["label" => "Senha"])
            ->getForm();

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()){
            $objDB = $this->getDoctrine()->getRepository(Professor::class);
            $data = $form->getData();
            $professor = new Professor();
            $professor->setEmail($data['email']);
            $professor->setSenha($data['pwd']);

            $buscaProfessor = $objDB->findOneBy([
                'email' => $professor->getEmail(),
                'senha' => $professor->getSenha()
            ]);

            if($buscaProfessor != null)
            {
                $session = new Session();
                $session->start();
                $session->set('professor', $buscaProfessor);
                
                return $this->redirectToRoute('app_sistema_inicial');
            }
            else
                $erro = "LOGIN INCORRETO!";
            //return $this->redirectToRoute('task_success');
        }
        return $this->render("base/inicial.TelaLogin.twig", [
                "titulo" => "Login do Sistema" ,
                "id" => "login", 
                "form" => $form->createView(),
                "erro" => $erro
            ]);
    }

    /**
     * 
     * @Route("/create-professor")
     */
    public function createProfessor(Request $request)
    {
        $retorno = "";
        $objDB = $this->getDoctrine()->getRepository(Professor::class);
        $form = $this->createFormBuilder()
            ->add('nome', TextType::class, ["label"=>"Nome"])
            ->add('email', TextType::class, ["label"=>"E-mail"])
            ->add('pwd', PasswordType::class, ["label" => "Senha"])
            ->getForm();

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $professor = new Professor();
            $professor->setNome($data['nome']);
            $professor->setEmail($data['email']);
            $professor->setSenha($data['pwd']);
            
            $buscaProfessor = $objDB->findOneBy([
                'nome' => $professor->getNome(),
                'email' => $professor->getEmail(),
            ]);
            
            if($buscaProfessor == null)
            {
                $objDB = $this->getDoctrine()->getManager();
                $objDB->persist($professor);
                $objDB->flush();
                $retorno = "Professor ". $data['nome']."(".$professor->getId().") cadastrado com sucesso!";
            }
            else
                $retorno = "Professor ". $data['nome']." já tem cadastrado no sistema!";
        }

        return $this->render("base/admin.CriarProfessor.twig", [
            "titulo" => "Criar Professor" ,
            "form" => $form->createView(),
            "retorno" => $retorno
        ]);
    }
}