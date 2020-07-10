<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Article;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuthorController extends AbstractController
{
    /**
     * @Route("/author/{id}", name="author_show")
     */
    public function showAction(NormalizerInterface $normalizer){
        $article = $this->getDoctrine()->getRepository(Article::class)->findOneById(1);

        $author = new Author();
        $author->setFullname('Prénom Nom');
        $author->setBiography('Ma super biographie');
        $author->getArticles()->add($article);

        // utiliser normalizer dans symfony 5
        $data = $normalizer->normalize($author, 'json');

        $json = json_encode($data);

        $response = new Response($json, 200, [
            "Content-Type" => "application/json"
        ]);

        return $response;
    }
}