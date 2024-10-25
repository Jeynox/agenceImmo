<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Enum\AdType;
use App\Enum\AdStatus;
use App\Repository\AdRepository;
use App\Repository\AgenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api/ad', name: 'api_ad_')]
class AdController extends AbstractController
{
    #[Route('/', name: 'all')]
    public function getAll(AdRepository $adRepository): Response
    {
        return $this->json($adRepository->findAll(), Response::HTTP_OK, [], ['groups' => 'ad:detail']);
    }

    #[Route('/{id}', name: 'one', methods: ['GET'])]
    public function getOne(int $id, AdRepository $adRepository): Response
    {
        return $this->json($adRepository->findOneBy(['id' => $id]), Response::HTTP_OK, [], ['groups' => 'ad:detail']);
    }

    #[IsGranted('ROLE_AGENCY')]
    #[Route('/new', name: 'new', methods: ['POST'], format: 'json')]
    public function add(EntityManagerInterface $entityManager, Request $request, Security $security, AgenceRepository $agenceRepository): Response
    {
        if (!$security->getUser()) {
            return $this->json(['error' => 'Utilisateur non authentifié'], Response::HTTP_UNAUTHORIZED);
        }

        $data = $request->toArray();
        $errors = [];

        $requiredFields = [
            'title' => 'Titre manquant.',
            'description' => 'Description manquante.',
            'price' => 'Prix manquant.',
            'surface' => 'Surface manquante.',
            'type' => 'Type manquant.',
            'address' => 'Adresse manquante.',
            'postalCode' => 'Code postal manquant.',
            'city' => 'Ville manquante.'
        ];

        foreach ($requiredFields as $field => $errorMessage) {
            if (empty($data[$field])) {
                $errors[$field] = $errorMessage;
            }
        }

        if (!empty($errors)) {
            return $this->json(['errors' => $errors], Response::HTTP_BAD_REQUEST);
        }

        $agence = $agenceRepository->findOneBy(['id' => $data['agence']]);

        if (!$agence) {
            return $this->json(['error' => 'Agence non trouvée'], Response::HTTP_BAD_REQUEST);
        }

        $ad = new Ad();
        $ad->setTitle($data['title']);
        $ad->setDescription($data['description']);
        $ad->setPrice($data['price']);
        $ad->setSurface($data['surface']);
        $ad->setType(AdType::from($data['type']));
        $ad->setAddress($data['address']);
        $ad->setPostalCode($data['postalCode']);
        $ad->setCity($data['city']);
        $ad->setStatus(AdStatus::from($data['status']));
        $ad->setAgence($agence);
        $ad->setCreatedAt(new \DateTimeImmutable());

        $entityManager->persist($ad);
        $entityManager->flush();

        return $this->json(['message' => 'enregistrement réussi'], Response::HTTP_CREATED);
    }

    #[IsGranted('ROLE_AGENCY')]
    #[Route('/edit/{id}', name: 'update', methods: ['PUT'], format: 'json')]
    public function update(int $id, EntityManagerInterface $entityManager, Request $request, AdRepository $adRepository, AgenceRepository $agenceRepository): Response
    {
        $ad = $adRepository->findOneBy(['id' => $id]);

        if (!$ad) {
            return $this->json(['error' => 'Annonce non trouvée.'], Response::HTTP_NOT_FOUND);
        }

        $data = $request->toArray();
        $errors = [];

        if (empty($data['title'])) {
            $errors['title'] = 'Titre manquant.';
        }

        if (empty($data['description'])) {
            $errors['description'] = 'Description manquante.';
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

        if (!empty($data['agence'])) {
            $agence = $agenceRepository->findOneBy(['id' => $data['agence']]);
            if (!$agence) {
                return $this->json(['error' => 'Agence non trouvée.'], Response::HTTP_BAD_REQUEST);
            }
            $ad->setAgence($agence);
        }

        if (!empty($errors)) {
            return $this->json(['errors' => $errors], Response::HTTP_BAD_REQUEST);
        }

        $ad->setTitle($data['title']);
        $ad->setDescription($data['description']);
        $ad->setAddress($data['address']);
        $ad->setPostalCode($data['postalCode']);
        $ad->setCity($data['city']);
        if (!empty($data['price'])) {
            $ad->setPrice($data['price']);
        }
        if (!empty($data['surface'])) {
            $ad->setSurface($data['surface']);
        }
        if (!empty($data['type'])) {
            $ad->setType(AdType::from($data['type']));
        }
        if (!empty($data['status'])) {
            $ad->setStatus(AdStatus::from($data['status']));
        }

        $entityManager->persist($ad);
        $entityManager->flush();

        return $this->json(['message' => 'Mise à jour réussie'], Response::HTTP_OK);
    }

    #[IsGranted('ROLE_AGENCY')]
    #[Route('/delete/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id, EntityManagerInterface $entityManager, AdRepository $adRepository): Response
    {
        $ad = $adRepository->findOneBy(['id' => $id]);

        if (!$ad) {
            return $this->json(['error' => 'Annonce non trouvée.'], Response::HTTP_NOT_FOUND);
        }

        $entityManager->remove($ad);
        $entityManager->flush();

        return $this->json(['message' => 'Suppression réussie'], Response::HTTP_NO_CONTENT);
    }
}
