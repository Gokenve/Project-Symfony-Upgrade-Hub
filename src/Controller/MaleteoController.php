<?php

namespace App\Controller;

use App\Entity\Demo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MaleteoController extends AbstractController {

    #[Route('/maleteo', name: 'maleteo', methods:['GET', 'POST'])]
    public function home(Request $request, EntityManagerInterface $doctrine) {

        $nombre = $request->request->get('name');
        $email = $request->request->get('email');
        $ciudad = $request->request->get('city');
        $checkbox = $request->request->get('checkbox');

        if ($checkbox === 'on') {
            $demo = new Demo;
            $demo -> setName("$nombre");
            $demo -> setEmail("$email");
            $demo -> setCity("$ciudad");

            $doctrine->persist($demo);

            $doctrine->flush();

            return $this-> render('/maleteo/mainMaleteo.html.twig', ['demo' => $demo, 'message' => 'Solicitud enviada.']);

        }

        return $this-> render('/maleteo/mainMaleteo.html.twig', ['message' => '']);


        
    }
}  