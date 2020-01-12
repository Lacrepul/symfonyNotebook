<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Note;
use App\Form\NoteType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;

class NoteController extends AbstractController
{
    /**
     * @Route("/note/{id}", name="app_note", requirements={"id"="\d+"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(Note $note){
        $note->setViews($note->getViews() + 1);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($note);
        $entityManager->flush();

        return $this->render('note/index.html.twig', [
            'note' => $note,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="app_deleteNote", requirements={"id"="\d+"})
     */
    public function deleteNote($id){
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Note::class)->find($id);
        $entityManager->remove($product);
        $entityManager->flush();

        return $this->redirectToRoute("main");
    }

    /**
     * @Route("/note/create", name="app_createNote")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function createNote(Request $request){
        $note = new Note();
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $note->setUsername($this->getUser());
            $note->setCreated(new \DateTime());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($note);
            $entityManager->flush();

            return $this->redirectToRoute('app_note', ['id' => $note->getId()]);
        }

        return $this->render('note/createNote.html.twig', [
            'noteForm' => $form->createView()
        ]);
    }
}
