<?php

namespace App\Controller\Api\V1\Author;

use App\Controller\Api\V1\Controller;
use App\Model\Redaction\UseCase\Author\Create\Command;
use App\Model\Redaction\UseCase\Author\Create\Handler as AuthorCreateHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/authors')]
class AuthorCreateController extends Controller
{
    public function __construct(
        private AuthorCreateHandler $authorCreateHandler
    )
    {
    }

    #[Route('' , methods: ['post'])]
    public function execute(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $cb = function () use ($data) {
            $command = new Command(
                name: $data['name'],
            );

            $this->authorCreateHandler->handle($command);
        };

        return $this->commonHandler($request, [], $cb);
    }
}