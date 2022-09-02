<?php

namespace App\Controller\Admin;

use App\Entity\Equipment;
use App\Entity\Images;
use App\Entity\ImageSystem;
use App\Form\EquipmentType;
use App\Repository\EquipmentRepository;
use App\Repository\ImageSystemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/equipment")
 */
class EquipmentController extends AbstractController
{
    /**
     * @Route("/", name="app_admin_equipment_index", methods={"GET"})
     */
    public function index(EquipmentRepository $equipmentRepository): Response
    {
        return $this->render('admin/equipment/index.html.twig', [
            'equipment' => $equipmentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_admin_equipment_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EquipmentRepository $equipmentRepository, EntityManagerInterface $em): Response
    {
        $equipment = new Equipment();
        $form = $this->createForm(EquipmentType::class, $equipment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $equipmentRepository->add($equipment, true);
            $empty = $form->get('imageSystem')->getData();

            if (!empty($empty)) {



                $images = $form->get('imageSystem')->getData();
                $fichier = md5(uniqid()) . '.' . $images->guessExtension();
                $images->move(
                    $this->getParameter('accessory_directory'),
                    $fichier
                );

                $img = new ImageSystem();
                $img->setName($fichier);
                $img->setEquipment($equipment);
                $equipment->setImageSystem($img);
            };

            $em->persist($equipment);
            $em->flush();

            return $this->redirectToRoute('app_admin_equipment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/equipment/new.html.twig', [
            'equipment' => $equipment,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_equipment_show", methods={"GET"})
     */
    public function show(Equipment $equipment): Response
    {
        return $this->render('admin/equipment/show.html.twig', [
            'equipment' => $equipment,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_admin_equipment_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Equipment $equipment, EquipmentRepository $equipmentRepository, EntityManagerInterface $em, ImageSystemRepository $imageSystem): Response
    {
        $form = $this->createForm(EquipmentType::class, $equipment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $equipmentRepository->add($equipment, true);
            $empty = $form->get('imageSystem')->getData();

            if (!empty($empty)) {

                // fonction pour effacer l'ancienne image de profil
                $userId = $equipment->getId();
                $ImgRmv = $imageSystem->findOneBy(['equipment' => $userId]);
                $ImgRmvName = $ImgRmv->getName();
                unlink($this->getParameter('accessory_directory') . '/' . $ImgRmvName);
                $em->remove($ImgRmv);
                $em->flush();

                $images = $form->get('imageSystem')->getData();
                $fichier = md5(uniqid()) . '.' . $images->guessExtension();
                $images->move(
                    $this->getParameter('accessory_directory'),
                    $fichier
                );

                $img = new ImageSystem();
                $img->setName($fichier);
                $img->setEquipment($equipment);
                $equipment->setImageSystem($img);
            };
            $em->flush();

            return $this->redirectToRoute('app_admin_equipment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/equipment/edit.html.twig', [
            'equipment' => $equipment,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_equipment_delete", methods={"POST"})
     */
    public function delete(Request $request, Equipment $equipment, EquipmentRepository $equipmentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $equipment->getId(), $request->request->get('_token'))) {
            $equipmentRepository->remove($equipment, true);
        }

        return $this->redirectToRoute('app_admin_equipment_index', [], Response::HTTP_SEE_OTHER);
    }
}
