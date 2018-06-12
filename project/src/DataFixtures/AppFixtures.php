<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setApiKey('test_api_key');
        $user->setUsername('test');
        $user->setPassword('test');
        $manager->persist($user);

        for ($i = 0; $i < 10; $i++) {
            $article = new Article();
            $article->setBody('This is a body of article ' . $i);

            for ($i2= 0; $i2 < $i; $i2++) {
                $comment = new Comment();
                $comment->setBody('This is the body of comment ' . $i2 . ' of article ' . $i);
                $comment->setArticle($article);
                $manager->persist($comment);
            }
            $manager->persist($article);
        }

        $manager->flush();
    }
}
