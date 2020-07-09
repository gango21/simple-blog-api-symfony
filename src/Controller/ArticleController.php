<?php

namespace App\Controller;

use App\Entity\Article;
use JMS\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    /**
     * @Route("/articles/{id}", name="article_show")
     */
    // public function showAction($id, SerializerInterface $serialize)
    // {
    //     $repository = $this->getDoctrine()->getRepository(Article::class); 
    //                 $article = $repository->findOneBy([
    //                     'id' => $id   
    //                 ]);
        
    //     $data = $serialize->serialize($article, 'json', SerializationContext::create()->setGroups(array('detail')));

    //     $response = new Response($data);
    //     $response->headers->set('Content-Type', 'application/json');

    //     return $response;
    // }

    /**
     * @Route("/articles/create", methods={"POST"}, name="article_create")
     */

     public function createAction(Request $request, SerializerInterface $serialize, EntityManagerInterface $manager)
     {
        $data = $request->getContent();
        $article = $serialize->deserialize($data, Article::class, 'json');

        $manager->persist($article);
        $manager->flush();

        return new Response('', Response::HTTP_CREATED);
     }


     /**
     * @Route("/articles", methods={"GET"}, name="articles_list")
     */

    public function listAction(SerializerInterface $serialize)
    {
        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();
        $data = $serialize->serialize($articles, 'json', SerializationContext::create()->setGroups(array('list')));

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
