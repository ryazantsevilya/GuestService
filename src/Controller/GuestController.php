<?php

namespace App\Controller;

use App\DTO\GuestDTO;
use App\Repository\GuestRepository;
use App\Service\GuestService;
use App\Validator\GuestValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route('guest')]
class GuestController extends AbstractController
{
    public function __construct(
        private GuestValidator $validator,
        private GuestService $guestService,
        private GuestRepository $guestRepository
    ) {
    }

    #[Route('/{id}', methods: ['GET'])]
    public function get(int $id): JsonResponse
    {
        $guest = $this->guestRepository->find($id);
        
        if (!$guest) {
            throw new NotFoundHttpException();
        }

        return $this->json($guest);
    }

    #[Route(methods: ['POST'])]
    public function create(#[MapRequestPayload()] GuestDTO $dto): JsonResponse
    {
        $this->validator->validate($dto);
        $guest = $this->guestService->createGuest($dto);

        return $this->json($guest);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function edit(int $id, #[MapRequestPayload()] GuestDTO $dto): JsonResponse
    {
        $guest = $this->guestRepository->find($id);

        if (!$guest) {
            throw new NotFoundHttpException();
        }
        
        $dto->setId($id);

        $this->validator->validate($dto, GuestValidator::CONTEXT_EDIT);
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
