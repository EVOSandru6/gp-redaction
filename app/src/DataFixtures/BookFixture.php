<?php

namespace App\DataFixtures;

use App\Model\Redaction\Entity\Book\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class BookFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $generator = Factory::create("ru_RU");

        for ($i = 0; $i < 10_000; $i++) {
            $book = new Book(
                name: $generator->title
            );

            $manager->persist($book);
        }

        $manager->flush();
    }
}
