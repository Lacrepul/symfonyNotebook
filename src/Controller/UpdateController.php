<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Note;
use App\Form\UpdateType;
use Symfony\Component\HttpFoundation\Request;

class UpdateController extends AbstractController
{
    /**
     * @Route("/update/{id}", name="app_update", requirements={"id"="\d+"})
     */
    public function index($id, Request $request){
        $note = new Note();
        $form = $this->createForm(UpdateType::class, $note);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $product = $entityManager->getRepository(Note::class)->find($id);

            $updatedBody = $form["body"]->getData();
            $updatedName = $form["noteName"]->getData();
            $product->setBody($updatedBody);
            $product->setNoteName($updatedName);
            $entityManager->flush();

            return $this->redirectToRoute('main');
        }

        return $this->render('update/index.html.twig', [
            'updateForm' => $form->createView()
        ]);
    }
}
