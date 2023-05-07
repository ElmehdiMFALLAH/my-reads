<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use App\Entity\Reads;
use App\Form\ReadsType;
use App\Form\Type\UpdateReadType;
use App\Repository\ReadRepository;
use Exception;

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
            
            try {
                $entityManager->persist($read);
                $entityManager->flush();
                $this->addFlash(
                    'notice',
                    'Added successfully!'
                );
            } catch (UniqueConstraintViolationException $e) {
                $this->addFlash(
                    'notice',
                    'This book already exists in your reads list!'
                );
                return $this->render('reads/new.html.twig', [
                    'form' => $form,
                    'alertClass' => 'alert-danger'
                ]);
            }

            return $this->render('reads/new.html.twig', [
                'form' => $form,
                'alertClass' => 'alert-success'
            ]);
        }
        return $this->render('reads/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/read/update/{id}', name: 'update_read')]
    public function update(Request $request, EntityManagerInterface $entityManager, Reads $read): Response
    {
        $form = $this->createForm(UpdateReadType::class, $read);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $read = $form->getData();
            
            try {
                $entityManager->persist($read);
                $entityManager->flush();
                $this->addFlash(
                    'notice',
                    'Updated successfully!'
                );
            } catch (Exception $e) {
                $this->addFlash(
                    'notice',
                    'The update has failed!'
                );
                return $this->render('reads/update.html.twig', [
                    'form' => $form,
                    'alertClass' => 'alert-danger'
                ]);
            }

            return $this->render('reads/update.html.twig', [
                'form' => $form,
                'alertClass' => 'alert-success'
            ]);
        }
        return $this->render('reads/update.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/reads', name: 'list_of_reads')]
    public function list(ReadRepository $readRepository): Response
    {
        $reads = $readRepository->findBy(
            ['user' => $this->getUser()]
        );

        return $this->render('reads/list.html.twig', [
            'reads' => $reads
        ]);
    }
}
