<?php

namespace App\Controller\Api\V1;

use DomainException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

abstract class Controller extends AbstractController
{
    protected function commonHandler(Request $request, array $rules = [], callable $cb = null, int $code = 200): JsonResponse
    {
        try {
            $data = $cb($request);

            $out = match (is_object($data)) {
                true => json_decode(json_encode($data), true),
                false => $data
            };

            $payload = [
                'data' => $out,
                'code' => $code,
                'message' => 'ok'
            ];

            return $this->json($payload, $code);
        } catch (DomainException $e) {
            return $this->json([
                'code' => 400,
                'message' => 'Предупреждение! ' . $e->getMessage(),
            ], 400);
        }
    }
}
