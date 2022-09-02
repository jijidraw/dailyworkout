<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Images;
use App\Entity\Message;
use App\Entity\User;
use App\Form\MessageType;
use App\Repository\ConversationRepository;
use App\Repository\MessageRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/message")
 */
class MessageController extends AbstractController
{
    /**
     * @Route("/", name="app_message")
     */
    public function index(ConversationRepository $conversationRepository, UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        $convA = $conversationRepository->findBy(['userA' => $user]);
        $convB = $conversationRepository->findBy(['userB' => $user]);
        $conversations = array_merge($convA, $convB);

        return $this->render('message/index.html.twig', [
            'controller_name' => 'MessageController',
            'conversations' => $conversations,
        ]);
    }
    /**
     * @Route("/conversation/{id}", name="app_conversation_show")
     */
    public function showConv(Conversation $conversation, MessageRepository $messageRepository, EntityManagerInterface $em, ConversationRepository $conversationRepository, Request $request): Response
    {
        $user = $this->getUser();
        $convA = $conversationRepository->findBy(['userA' => $user], ['updated_at' => 'DESC']);
        $convB = $conversationRepository->findBy(['userB' => $user], ['updated_at' => 'DESC']);
        $conversations = array_merge($convA, $convB);
        $messages = $messageRepository->findBy(['conversation' => $conversation], ['created_at' => 'DESC']);
        if (!empty($lastmessage)) {
            $lastmessage = $messages[0]->getUser();
            if ($lastmessage != $user) {
                foreach ($messages as $message) {
                    $message->setIsRead(true);
                    $messageRepository->add($message, true);
                }
            }
        }

        // message
        $message = new Message();
        $Form = $this->createForm(MessageType::class, $message);
        $Form->handleRequest($request);


        if ($Form->isSubmitted() && $Form->isValid()) {
            $message->setUser($user)->setIsRead(false)->setConversation($conversation);
            $messageRepository->add($message, true);
            $empty = $Form->get('image')->getData();

            if (!empty($empty)) {

                $images = $Form->get('image')->getData();
                $fichier = md5(uniqid()) . '.' . $images->guessExtension();
                $images->move(
                    $this->getParameter('post_directory'),
                    $fichier
                );

                $img = new Images();
                $img->setName($fichier);
                $message->setImage($img);
            };
            $em->persist($message);
            $em->flush();
            $conversation->setUpdatedAt(new DateTime());
            $conversationRepository->add($conversation, true);
            // message

            return $this->redirectToRoute('app_conversation_show', ['id' => $conversation->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('message/showConversation.html.twig', [
            'controller_name' => 'MessageController',
            'conversation' => $conversation,
            'form' => $Form->createView(),
            'conversations' => $conversations,
            'messages' => $messages
        ]);
    }
    /**
     * @Route("/newMessages/{conv}", name="app_message_new", methods={"POST", "GET"})
     */
    public function newMessage(EntityManagerInterface $em, MessageRepository $messageRepository, Conversation $conv)
    {
        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body, false);
        $user = $this->getUser();
        $message = new Message;
        $message->setUser($user)->setContent($data)->setConversation($conv)->setIsRead(false);
        $em->persist($message);
        $em->flush();
        return $this->json([
            'code' => 200,
            'message' => 'Commentaire bien ajouté',
            'messages' => $messageRepository->findBy(['conversation' => $conv], ['created_at' => 'DESC'])
        ], 200);
    }
    /**
     * @Route("/loadConversation/{conv}", name="app_conversation_get", methods={"GET", "POST"})
     */
    public function loadConversation(MessageRepository $messageRepository, Conversation $conv)
    {
        return $this->json([
            'messages' => $messageRepository->findBy(['conversation' => $conv], ['created_at' => 'DESC'])
        ], 200);
    }
}
