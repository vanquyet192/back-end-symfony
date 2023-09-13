<?php

namespace App\Controller;

use App\Entity\RoleAdmin;
use App\Form\RoleAdminType;
use App\Repository\RoleAdminRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/role/admin')]
class RoleAdminController extends AbstractController
{
    #[Route('/', name: 'app_role_admin_index', methods: ['GET'])]
    public function index(RoleAdminRepository $roleAdminRepository): Response
    {
        return $this->render('role_admin/index.html.twig', [
            'role_admins' => $roleAdminRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_role_admin_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $roleAdmin = new RoleAdmin();
        $form = $this->createForm(RoleAdminType::class, $roleAdmin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($roleAdmin);
            $entityManager->flush();

            return $this->redirectToRoute('app_role_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('role_admin/new.html.twig', [
            'role_admin' => $roleAdmin,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_role_admin_show', methods: ['GET'])]
    public function show(RoleAdmin $roleAdmin): Response
    {
        return $this->render('role_admin/show.html.twig', [
            'role_admin' => $roleAdmin,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_role_admin_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RoleAdmin $roleAdmin, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RoleAdminType::class, $roleAdmin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_role_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('role_admin/edit.html.twig', [
            'role_admin' => $roleAdmin,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_role_admin_delete', methods: ['POST'])]
    public function delete(Request $request, RoleAdmin $roleAdmin, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$roleAdmin->getId(), $request->request->get('_token'))) {
            $entityManager->remove($roleAdmin);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_role_admin_index', [], Response::HTTP_SEE_OTHER);
    }
}
