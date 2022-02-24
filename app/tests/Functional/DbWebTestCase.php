<?php

namespace App\Tests\Functional;

use App\Tests\DatabasePrimer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DbWebTestCase extends WebTestCase
{
    protected EntityManagerInterface $em;
    protected KernelBrowser $client;

    protected const API_PREFIX = '/api/v1';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->client->disableReboot();
        $kernel = self::bootKernel();
        DatabasePrimer::prime($kernel);
        $this->em = $kernel->getContainer()->get('doctrine')->getManager();
    }

    protected function tearDown(): void
    {
        $this->em->close();
        parent::tearDown();
    }
}
