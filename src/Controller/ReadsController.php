<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;
use App\Entity\Reads;
use App\Form\ReadsType;
use App\Form\Type\UpdateReadType;
use App\Repository\ReadRepository;

class ReadsController extends AbstractController
{
    #[Route('/reads/create', name: 'create_read')]
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
                return $this->render('reads/list.html.twig', [
                    'alertClass' => 'alert-danger'
                ]);
            }

            return $this->render('reads/list.html.twig', [
                'alertClass' => 'alert-success'
            ]);
        }
        return $this->render('reads/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/reads/update/{id}', name: 'update_read')]
    public function update(Request $request, EntityManagerInterface $entityManager, Reads $read): Response
    {
        $form = $this->createForm(UpdateReadType::class, $read);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $read = $form->getData();
            if ($read->getProgress() > $read->getBook()->getPages()) {
                $this->addFlash(
                    'notice',
                    'The progress cannot be higher than number of pages !'
                );
                return $this->render('reads/update.html.twig', [
                    'form' => $form,
                    'read' => $read,
                    'alertClass' => 'alert-danger'
                ]);
            }
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
                    'read' => $read,
                    'alertClass' => 'alert-danger'
                ]);
            }

            return $this->render('reads/update.html.twig', [
                'form' => $form,
                'read' => $read,
                'alertClass' => 'alert-success'
            ]);
        }
        return $this->render('reads/update.html.twig', [
            'form' => $form,
            'read' => $read
        ]);
    }

    #[Route('/reads', name: 'list_of_reads')]
    public function list(ReadRepository $readRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $alertClass = '';
        
        $newRead = new Reads();
        $createForm = $this->createForm(ReadsType::class, $newRead);
        
        $createForm->handleRequest($request);
        if ($createForm->isSubmitted() && $createForm->isValid()) {
            $newRead = $createForm->getData();

            if ($newRead->getProgress() > $newRead->getBook()->getPages()) {
                $this->addFlash(
                    'notice',
                    'The progress cannot be higher than number of pages !'
                );
                $alertClass = 'alert-danger';
            } else {
                $newRead->setUser($this->getUser());

                try {
                    $entityManager->persist($newRead);
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
                    $alertClass = 'alert-danger';
                }
    
                $alertClass = 'alert-success';
            }
        }

        $reads = $readRepository->findBy(
            ['user' => $this->getUser()]
        );

        return $this->render('reads/list.html.twig', [
            'reads' => $reads,
            'createForm' => $createForm,
            'alertClass' => $alertClass
        ]);
    }

    #[Route('/reads/delete/{id}', name: 'delete_read', methods: 'DELETE')]
    public function delete(Reads $read, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $entityManager->remove($read);
            $entityManager->flush();

            return new JsonResponse(["message" => "success"], 200);
        } catch (Exception $e) {
            return new JsonResponse(["message" => "failed"], 500);
        }
    }
}
