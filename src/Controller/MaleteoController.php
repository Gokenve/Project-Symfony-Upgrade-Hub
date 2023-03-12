<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MaleteoController extends AbstractController {

    #[Route('/maleteo')]
    public function home() {
        return $this-> render('/maleteo/mainMaleteo.html.twig');
    }
}  