<?php

namespace App\Controller\Admin;

use App\Entity\ArticleCategory;
use App\Form\ArticleCategoryType;
use App\Repository\ArticleCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/article/category')]
class ArticleCategoryController extends AbstractController
{
    #[Route('/', name: 'app_admin_article_category_index', methods: ['GET'])]
    public function index(ArticleCategoryRepository $articleCategoryRepository): Response
    {
        return $this->render('admin/article_category/index.html.twig', [
            'article_categories' => $articleCategoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_article_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ArticleCategoryRepository $articleCategoryRepository): Response
    {
        $articleCategory = new ArticleCategory();
        $form = $this->createForm(ArticleCategoryType::class, $articleCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articleCategoryRepository->add($articleCategory, true);

            return $this->redirectToRoute('app_admin_article_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/article_category/new.html.twig', [
            'article_category' => $articleCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_article_category_show', methods: ['GET'])]
    public function show(ArticleCategory $articleCategory): Response
    {
        return $this->render('admin/article_category/show.html.twig', [
            'article_category' => $articleCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_article_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ArticleCategory $articleCategory, ArticleCategoryRepository $articleCategoryRepository): Response
    {
        $form = $this->createForm(ArticleCategoryType::class, $articleCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articleCategoryRepository->add($articleCategory, true);

            return $this->redirectToRoute('app_admin_article_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/article_category/edit.html.twig', [
            'article_category' => $articleCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_article_category_delete', methods: ['POST'])]
    public function delete(Request $request, ArticleCategory $articleCategory, ArticleCategoryRepository $articleCategoryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$articleCategory->getId(), $request->request->get('_token'))) {
            $articleCategoryRepository->remove($articleCategory, true);
        }

        return $this->redirectToRoute('app_admin_article_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
