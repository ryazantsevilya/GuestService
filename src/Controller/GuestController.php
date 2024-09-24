<?php

namespace App\Controller;

use App\DTO\GuestDTO;
use App\Service\GuestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route('guest')]
class GuestController extends AbstractController
{
    public function __construct(
        private GuestService $guestService
    ) {
    }

    #[Route('/{id}', methods: ['GET'])]
    public function get(int $id): JsonResponse
    {
        $guest = $this->guestService->getGuest($id);

        if (!$guest) {
            throw new NotFoundHttpException();
        }

        return $this->json($guest);
    }

    #[Route(methods: ['POST'])]
    public function create(#[MapRequestPayload()] GuestDTO $dto): JsonResponse
    {
        $guest = $this->guestService->createGuest($dto);

        return $this->json($guest);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function edit(int $id, #[MapRequestPayload()] GuestDTO $dto): JsonResponse
    {
        $guest = $this->guestService->getGuest($id);

        if (!$guest) {
            throw new NotFoundHttpException();
        }

        $dto->setId($id);

        $guest = $this->guestService->editGuest($id, $dto);

        return $this->json($guest);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        if (!$this->guestService->deleteGuest($id)) {
            throw new NotFoundHttpException();
        }

        return $this->json(
            ['Гость ' . $id . ' удален.']
        );
    }
}
