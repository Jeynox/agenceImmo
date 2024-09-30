<?php

namespace App\Controller\User;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTEncoderInterface;

#[Route(path: '/api', name: 'api_')]
class ApiSecurityController extends AbstractController
{
    #[Route('/api/login', name: 'api_login', methods: 'POST')]
    public function index(#[CurrentUser] ?User $user, Request $request, JWTEncoderInterface $jwtEncoder): Response
    {
        if (null === $user) {
            return $this->json([
                'message' => 'Wrong credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = $jwtEncoder->encode([
            'username' => $user->getUserIdentifier(), 
            'exp' => time() + 3600,
        ]);

        return $this->json([
            'user'  => $user->getUserIdentifier(),
            'token' => $token,
            'referrer' => $request->headers->get('referer')
        ]);
    }


    #[Route(path: '/logout', name: 'logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
