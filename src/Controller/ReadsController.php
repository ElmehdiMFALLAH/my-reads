<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Reads;
use App\Form\ReadsType;
use App\Repository\ReadRepository;

class ReadsController extends AbstractController
{
    #[Route('/read/create', name: 'create_read')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $read = new Reads();

        $form = $this->createForm(ReadsType::class, $read);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $read = $form->getData();
            $read->setUser($this->getUser());
            
            $entityManager->persist($read);
            $entityManager->flush();

            return $this->redirectToRoute('list_of_reads');
        }
        return $this->render('reads/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/reads', name: 'list_of_reads')]
    public function list(ReadRepository $readRepository): Response
    {
        $reads = $readRepository->findAll();

        return $this->render('reads/list.html.twig', [
            'reads' => $reads,
        ]);
    }
}
