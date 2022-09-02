<?php

namespace App\Controller\Admin;

use App\Entity\EquipmentCategory;
use App\Form\EquipmentCategoryType;
use App\Repository\EquipmentCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/equipment/category')]
class EquipmentCategoryController extends AbstractController
{
    #[Route('/', name: 'app_admin_equipment_category_index', methods: ['GET'])]
    public function index(EquipmentCategoryRepository $equipmentCategoryRepository): Response
    {
        return $this->render('admin/equipment_category/index.html.twig', [
            'equipment_categories' => $equipmentCategoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_equipment_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EquipmentCategoryRepository $equipmentCategoryRepository): Response
    {
        $equipmentCategory = new EquipmentCategory();
        $form = $this->createForm(EquipmentCategoryType::class, $equipmentCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $equipmentCategoryRepository->add($equipmentCategory, true);

            return $this->redirectToRoute('app_admin_equipment_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/equipment_category/new.html.twig', [
            'equipment_category' => $equipmentCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_equipment_category_show', methods: ['GET'])]
    public function show(EquipmentCategory $equipmentCategory): Response
    {
        return $this->render('admin/equipment_category/show.html.twig', [
            'equipment_category' => $equipmentCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_equipment_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EquipmentCategory $equipmentCategory, EquipmentCategoryRepository $equipmentCategoryRepository): Response
    {
        $form = $this->createForm(EquipmentCategoryType::class, $equipmentCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $equipmentCategoryRepository->add($equipmentCategory, true);

            return $this->redirectToRoute('app_admin_equipment_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/equipment_category/edit.html.twig', [
            'equipment_category' => $equipmentCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_equipment_category_delete', methods: ['POST'])]
    public function delete(Request $request, EquipmentCategory $equipmentCategory, EquipmentCategoryRepository $equipmentCategoryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$equipmentCategory->getId(), $request->request->get('_token'))) {
            $equipmentCategoryRepository->remove($equipmentCategory, true);
        }

        return $this->redirectToRoute('app_admin_equipment_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
