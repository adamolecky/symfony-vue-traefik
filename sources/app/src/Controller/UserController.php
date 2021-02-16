<?php

namespace App\Controller;

use App\Entity\User;
use App\Helpers\ErrorHelper;
use App\Helpers\RequestHelper;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use ErrorEnum;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    public function __construct(
        protected UserRepository $userRepository,
        protected LoggerInterface $logger,
        protected EntityManagerInterface $entityManager,
        protected RequestHelper $requestHelper,
        protected ErrorHelper $errorHelper
    ) {}

    #[Route('/api/user/list', name: 'user_list', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return new JsonResponse(array_map(function (User $user) {
            return $this->userRepository->getUserAsArray($user);
        }, $this->userRepository->findAll()));

    }

    #[Route('/api/user/create', name: 'user_create', methods: ['POST', 'GET'])]
    public function create(ValidatorInterface $validator, Request $request): Response
    {
        //TODO: side note: This could be solved via Forms component. But i want to use this approach to demonstrate skills.
        $response = [];
        $user = new User();
        $user = $this->requestHelper->fillEntityFromRequest($request, $user);
        $errors = $validator->validate($user);
        if ($errors->count()) {
            $response = (array)($this->errorHelper->createErrorResponse($errors));
        } else {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $response = (array)($this->userRepository->getUserAsArray($user));
        }
        return new JsonResponse($response);
    }


}
