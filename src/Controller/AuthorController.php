<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuthorController extends AbstractController
{
    /**
     * @Route("/author/{id}", name="author_show")
     */
    public function showAction(SerializerInterface $serializer, $id){

        $repository = $this->getDoctrine()->getRepository(Author::class); 
                    $author = $repository->findOneBy([
                        'id' => $id   
                    ]);

        $data = $serializer->serialize($author, 'json');

        $response = new Response($data, 200, [
            "Content-Type" => "application/json"
        ]);

        return $response;
    }

    /**
     * @Route("/authors", methods={"POST"}, name="author_create")
     */
    public function createAction(Request $request, SerializerInterface $serializer, EntityManagerInterface $manager)
    {
        $data = $request->getContent();
        $author = $serializer->deserialize($data, Author::class, "json");

        $manager->persist($author);
        $manager->flush();

        return new Response('', Response::HTTP_CREATED);
    }

}