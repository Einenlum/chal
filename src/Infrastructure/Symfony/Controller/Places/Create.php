<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Controller\Places;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

final class Create
{
    /**
     * @Route("/places", name="places_create", methods={"POST"})
     */
    public function __invoke(Request $request)
    {
    }
}
