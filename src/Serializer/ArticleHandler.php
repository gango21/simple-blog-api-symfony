<?php

namespace App\Serializer\Handler;

use App\Entity\Article;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\JsonSerializationVisitor;
use JMS\Serializer\JsonDeserializationVisitor;
use JMS\Serializer\SerializationContext as Context;
use JMS\Serializer\Handler\SubscribingHandlerInterface;

class ArticleHandler implements SubscribingHandlerInterface
{
    public static function getSubscribingMethods()
    {
        return [
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'json',
                'type' => 'App\Entity\Article',
                'method' => 'serialize',
            ],
            [
                'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                'format' => 'json',
                'type' => 'App\Entity\Article',
                'method' => 'deserialize',
            ]
        ];
    }

    public function serialize(JsonSerializationVisitor $visitor, Article $article, array $type, Context $context)
    {
        // L'on reçoit un objet à serialiser (dans cet exemple $article)
        // Puis nous pouvons manipuler le graph d'objet grâce à l'objet visitor

        $date = new \Datetime();

        // Cette méthode doit retourner un tableau ou une chaîne de caractère.
        $data = [
            'title' => $article->getTitle(),
            'conent' => $article->getContent(),
            'delivered_at' => $date->format('l jS \of F Y h:i:s A')
        ];

        // La tableau est vérifié avec visitArray() accessible depuis l'objet JsonSerializationVisitorJsonSerializationVisitor.
        return $visitor->visitArray($data, $type, $context);
    }

    public function deserialize(JsonDeserializationVisitor $visitor, $data)
    {
        // Dans cet exemple, la méthode doit retourner un objet de type App\Entity\Article
        
        $article = new Article;
        $article->setTitle($data['title']);
        $article->setContent($data['content']);
        return $article;
    }

}

?>