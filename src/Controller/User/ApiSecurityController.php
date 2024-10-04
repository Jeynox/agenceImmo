<?php

namespace App\Controller\User;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

#[Route(path: 'api/', name: 'api_')]
class ApiSecurityController extends AbstractController
{
    #[Route('login', name: 'login', methods: ['POST'])]
    public function index(#[CurrentUser] ?User $user, JWTTokenManagerInterface $jwtManager): Response
    {
        if (null === $user) {
            return $this->json([
                'message' => 'Wrong credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = $jwtManager->create($user);
        
        return $this->json([
            'user'  => $user->getUserIdentifier(),
            'token' => $token,
            'message' => 'Valid credentials'
        ], Response::HTTP_OK);
    }


    #[Route(path: '/logout', name: 'logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
