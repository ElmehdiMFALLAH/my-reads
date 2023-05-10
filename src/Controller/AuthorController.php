<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\Type\AuthorType;
use App\Entity\Author;
use App\Repository\AuthorRepository;

class AuthorController extends AbstractController
{
    #[Route('/authors/create', name: 'create_author')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $author = new Author();

        $form = $this->createForm(AuthorType::class, $author);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $author = $form->getData();
            $entityManager->persist($author);
            $entityManager->flush();

            return $this->redirectToRoute('list_of_authors');
        }
        return $this->render('author/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/authors', name: 'list_of_authors')]
    public function list(AuthorRepository $authorRepository): Response
    {
        $authors = $authorRepository->findAll();

        return $this->render('author/list.html.twig', [
            'authors' => $authors,
        ]);
    }
}
