<?php

namespace App\Controller\User;

use App\Entity\Post;
use App\Form\Post1Type;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/{id}", name="app_user_post_show", methods={"GET"})
     */
    public function index(Post $post): Response
    {
        return $this->render('user/post/show.html.twig', [
            'post' => $post,
        ]);
    }

    /**
     * @Route("/{id}/delete", name="app_user_post_delete", methods={"POST"})
     */
    public function delete(Request $request, Post $post, PostRepository $postRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $post->getId(), $request->request->get('_token'))) {
            $images = $post->getImages();
            if ($images) {
                foreach ($images as $image) {
                    $imgName = $this->getParameter('post_directory') . '/' . $image->getName();
                    if (file_exists($imgName)) {
                        unlink($imgName);
                    }
                }
            }
            $postRepository->remove($post, true);
        }

        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }
}
