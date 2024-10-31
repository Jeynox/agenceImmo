<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Service\EmailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('sign', name: 'sign', methods: ['POST'])]
    public function register(Request $request, EntityManagerInterface $entityManager, EmailService $emailService): Response
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

        //Générer le token de confirmation
        $token = bin2hex(random_bytes(32));
        $user->setConfirmationToken($token);
        
        // Persister et sauvegarder l'entité
        $entityManager->persist($user);
        $entityManager->flush();

        // Préparer l'URL de confirmation
        $confirmationUrl = sprintf('http://127.0.0.1:8000/confirmation/%s', $token);

        $emailService->sendConfirmationEmail($email, $confirmationUrl);

        return $this->json([
            'message' => 'Enregistrement effectué avec succès, veuillez consulter votre boîte mail pour confirmer votre inscription.',
        ], Response::HTTP_CREATED);
    }

    #[Route('confirmation/{token}', name: 'confirmation')]
    public function confirm(string $token, EntityManagerInterface $entityManager): Response
    {
        // Cherchez l'utilisateur par le token de confirmation
        $user = $entityManager->getRepository(User::class)->findOneBy(['confirmationToken' => $token]);

        if (!$user) {
            // Si aucun utilisateur n'est trouvé, retournez une erreur
            return $this->json(['message' => 'Token de confirmation invalide.'], Response::HTTP_BAD_REQUEST);
        }

        // Mettez à jour l'état de l'utilisateur (par exemple, activer le compte)
        $user->setIsActive(true); // Assurez-vous que cette méthode existe dans votre entité User
        $user->setConfirmationToken(null); // Réinitialiser le token de confirmation
        $entityManager->flush();

        // Redirigez vers la page de connexion ou une autre page
        return $this->json(['message' => 'Votre compte a été confirmé avec succès. Vous pouvez maintenant vous connecter.'], Response::HTTP_OK);
    }

    #[Route(path: '/logout', name: 'logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
