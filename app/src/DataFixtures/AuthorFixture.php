<?php

namespace App\DataFixtures;

use App\Model\Redaction\Entity\Author\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AuthorFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $generator = Factory::create("ru_RU");

        for ($i = 0; $i < 10_000; $i++) {
            $book = new Author(
                name: $generator->name
            );

            $manager->persist($book);
        }

        $manager->flush();
    }
}
