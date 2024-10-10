<?php

namespace App\Controller\Agence;

use App\Entity\Agence;
use App\Repository\AgenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_AGENCY')]
#[Route('api/agence', name: 'api_agence_')]
class AgenceController extends AbstractController
{
    #[Route('/', name: 'all', methods: ['GET'])]
    public function getAll(AgenceRepository $agenceRepository): Response
    {
        return $this->json($agenceRepository->findAll(), Response::HTTP_OK);
    }

    #[Route('/new', name: 'new', methods: ['POST'], format: 'json')]
    public function add(EntityManagerInterface $entityManager, Request $request, Security $security): Response
    {

        if (!$security->getUser()) {
            return $this->json(['error' => 'Utilisateur non authentifié'], Response::HTTP_UNAUTHORIZED);
        }

        $data = $request->toArray();
        $errors = [];

        if (empty($data['email'])) {
            $errors['email'] = 'Email manquant.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email invalide.';
        }

        if (empty($data['name'])) {
            $errors['name'] = 'Nom de l\'agence manquant.';
        }

        if (empty($data['address'])) {
            $errors['address'] = 'Adresse manquante.';
        }

        if (empty($data['postalCode'])) {
            $errors['postalCode'] = 'Code postal manquant.';
        }

        if (empty($data['city'])) {
            $errors['city'] = 'Ville manquante.';
        }

        if (empty($data['website'])) {
            $errors['website'] = 'Site web manquant.';
        }

        if (!empty($errors)) {
            return $this->json(['errors' => $errors], Response::HTTP_BAD_REQUEST);
        }

        $agence = new Agence();
        $agence->setEmail($data['email']);
        $agence->setName($data['name']);
        $agence->setAdress($data['address']);
        $agence->setPostalCode($data['postalCode']);
        $agence->setCity($data['city']);
        $agence->setWebsite($data['website']);
        $agence->setUser($security->getUser());

        $entityManager->persist($agence);
        $entityManager->flush();

        return $this->json(['message' => 'enregistrement réussi'], Response::HTTP_CREATED);
    }

    #[Route('/edit/{id}', name: 'update', methods: ['PUT'], format: 'json')]
    public function update(int $id, EntityManagerInterface $entityManager, Request $request, AgenceRepository $agenceRepository): Response
    {
        $agence = $agenceRepository->findOneBy(['id' => $id]);

        if (!$agence) {
            return $this->json(['error' => 'Agence non trouvée.'], Response::HTTP_NOT_FOUND);
        }

        $data = $request->toArray();
        $errors = [];

        if (empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email invalide.';
        }

        if (empty($data['name'])) {
            $errors['name'] = 'Nom de l\'agence manquant.';
        }

        if (empty($data['address'])) {
            $errors['address'] = 'Adresse manquante.';
        }

        if (empty($data['postalCode'])) {
            $errors['postalCode'] = 'Code postal manquant.';
        }

        if (empty($data['city'])) {
            $errors['city'] = 'Ville manquante.';
        }

        if (empty($data['website'])) {
            $errors['website'] = 'Site web manquant.';
        }

        if (!empty($errors)) {
            return $this->json(['errors' => $errors], Response::HTTP_BAD_REQUEST);
        }

        $agence->setEmail($data['email']);
        $agence->setName($data['name']);
        $agence->setAdress($data['address']);
        $agence->setPostalCode($data['postalCode']);
        $agence->setCity($data['city']);
        $agence->setWebsite($data['website']);

        $entityManager->persist($agence);
        $entityManager->flush();

        return $this->json(['message' => 'Mise à jour réussie'], Response::HTTP_OK);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id, EntityManagerInterface $entityManager, AgenceRepository $agenceRepository): Response
    {
        $agence = $agenceRepository->findOneBy(['id' => $id]);

        if (!$agence) {
            return $this->json(['error' => 'Agence non trouvée.'], Response::HTTP_NOT_FOUND);
        }

        $entityManager->remove($agence);
        $entityManager->flush();

        return $this->json(['message' => 'Suppression réussie'], Response::HTTP_NO_CONTENT);
    }

    
}
