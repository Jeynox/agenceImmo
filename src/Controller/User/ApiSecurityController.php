<?php

namespace App\Controller\User;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Request;

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

    #[Route('sign', name: 'sign', methods: ['POST'])]
    public function register(Request $request, EntityManagerInterface $entityManager): Response
    {

        $user = new User();
         // Récupérer les données de la requête
        $data = json_decode($request->getContent(), true); // récupérer le contenu JSON du body

        // On recupere l'adresse mail de l'utilisateur lors de l'inscription
        $email = $data['email'];

        // On vérifie si l'adresse mail existe déjà dans la base de données
        $existingUser = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

        // Si l'adresse mail existe déjà, on retourne un message d'erreur
        if($existingUser) {
            return $this->json([
                'message' => 'Erreur lors de l\'inscription',
            ], Response::HTTP_CONFLICT);
        }

        // Hacher le mot de passe
        $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);

        // Assigner les valeurs à l'entité User
        $user->setEmail($email);
        $user->setPassword($passwordHash); // Attention, il faudrait hacher le mot de passe ici !
        $user->setRoles(['ROLE_USER']);

        // Persister et sauvegarder l'entité
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json([
            'message' => 'Enregistrement effectué avec succès',
        ], Response::HTTP_CREATED);
    }


    #[Route(path: '/logout', name: 'logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
