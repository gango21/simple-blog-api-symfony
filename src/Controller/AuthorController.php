<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Article;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuthorController extends AbstractController
{
    /**
     * @Route("/author/{id}", name="author_show")
     */
    public function showAction(SerializerInterface $serializer){
        $article = $this->getDoctrine()->getRepository(Article::class)->findOneById(1);

        $author = new Author();
        $author->setFullname('Prénom Nom');
        $author->setBiography('Ma super biographie');
        $author->getArticles()->add($article);

        $data = $serializer->serialize($author, 'json');

        $response = new Response($data, 200, [
            "Content-Type" => "application/json"
        ]);

        return $response;
    }

}