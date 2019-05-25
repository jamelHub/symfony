<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Article;
use Doctrine\Common\Persistence\ObjectManager;
use App\Repository\ArticleRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\ArticleType;
class AnnonceController extends AbstractController
{
    /**
     * @Route("/annonce", name="annonce")
     */
    public function index(ArticleRepository $repo)
    {        $articles=$repo->findAll();
        return $this->render('annonce/index.html.twig', [
            'controller_name' => 'AnnonceController',
        'articles'=>$articles
            ]);
    }
    /**
     * @Route("/", name="home")
     */
    public function home ()
    {
        return $this->render('annonce/home.html.twig');
    }
 
     /**
      * @Route("/annonce/new",name="annonce_create")
      *@Route("/annonce/{id}/edit",name="annonce_edit")
      */
    public function form ( Article $article =null ,Request $request ,ObjectManager $manager)
    {
        if(!$article){
            $article = new Article();
        }
            /*  $form=$this->createFormBuilder($article)
                    ->add('title', TextType::class,[
                        'attr' =>[
                            'placeholder' =>"title de l'article"
                        ]
                    ])   
                    ->add('content',TextareaType::class,[
                        'attr' =>[
                            'placeholder' =>"content de l'articel"
                            ]
                    ]) 
                    ->add('image',TextType::class,[
                        'attr' =>[
                            'placeholder' =>"image de l'article"
                            
                        ]
                    ]) 
                    
                    ->getForm(); */
                 $form = $this->createForm(ArticleType::class,$article);
                
                 $form->handleRequest($request);
                if($form->isSubmitted() && $form->isValid())
                {
                    if(!$article->getId())
                    {                        
                        $article->setCreatedAt(new \Datetime());

                    }
                    $manager->persist($article);
                    $manager->flush();
                    return $this->redirectToRoute('annonce_show',['id' => $article->getId()]);
                }

        
        return $this->render('annonce/create.html.twig',['formArticle' => $form->createView(),'editMode'=>$article->getId() !== null]);
    
    }
    /**
     * @Route("/annonce/{id}",name="annonce_show")
     */
    public function show(Article $article)
    {
        return $this->render('annonce/show.html.twig',['article' => $article]);
    }
 

}
