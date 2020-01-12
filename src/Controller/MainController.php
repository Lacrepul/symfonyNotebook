<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\NoteRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(NoteRepository $noteRepository){
        $notes = $noteRepository->findBy([], ['created' => 'DESC']);

        return $this->render('main/index.html.twig', [
            'notes' => $notes,
        ]);
    }
}
