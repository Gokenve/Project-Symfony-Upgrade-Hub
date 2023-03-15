<?php

namespace App\Controller;

use App\Entity\Demo;
use App\Entity\Opinions;
use App\Form\GuardianType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MaleteoController extends AbstractController {

    
    #[Route('/maleteo', name: 'maleteo', methods:['GET', 'POST'])]
    public function home(Request $request, EntityManagerInterface $doctrine) {

        $repositorio = $doctrine->getRepository(Opinions::class);
        $opinions = $repositorio->findByLastThreeOpinions();

        // Otra manera de haber conseguido las últimas 3 opiniones 
        //! $opinions = $repositorio->findBy([],['id'=>'DESC'], 3);

        $nombre = $request->request->get('name');
        $email = $request->request->get('email');
        $ciudad = $request->request->get('city');

        // No encontre otra forma para validar el formulario y enviarlo a BBDD
        if ($_POST) {
            $demo = new Demo;
            $demo -> setName("$nombre");
            $demo -> setEmail("$email");
            $demo -> setCity("$ciudad");

            $doctrine->persist($demo);

            $doctrine->flush();
            $this-> addFlash('success', 'Petición de demo enviada correctamente!!');
            return $this-> render('/maleteo/mainMaleteo.html.twig', ['demo' => $demo, 'opinions' => $opinions]);

        }

        return $this-> render('/maleteo/mainMaleteo.html.twig', ['message' => '', 'opinions' => $opinions]);
        
    }

    // Ruta creada para poblar la tabla opiniones de la BBDD
    #[Route('/opinions/seed')]
    public function opinionsSeed(EntityManagerInterface $doctrine) {

        $opinion1 = new Opinions();
        $opinion1->setComent('Tras el enorme éxito internacional de su primera colaboración, “Bailar”, que ganó un galardón en los Premios');
        $opinion1->setAuthor('Sergio Garnacho');
        $opinion1->setCity('Madrid');

        $opinion2 = new Opinions();
        $opinion2->setComent('En Colombia es cargar con algo grande, casi siempre pesado e incómodo de llevar. Bultear, cargar. Llevar equipaje pesado e incómodo. El término lo utilizamos para referenciar que ha sido muy difícil transportar lo que trajimos (se usa a manera de protesta)');
        $opinion2->setAuthor('Danilo Enrique');
        $opinion2->setCity('Barcelona');

        $opinion3 = new Opinions();
        $opinion3->setComent('En la jerga coloquial venezolana "Maletear" significa cuando la conyuge bota o expulsa al otro conyuge de su casa');
        $opinion3->setAuthor('Jaime Aragón');
        $opinion3->setCity('Sevilla');

        $opinion4 = new Opinions();
        $opinion4->setComent('En la jerga peruana "maletear" significa hablar a espaldas de alguien. A la espalda le dicen "maleta". Maletear también significa golpear o pegar');
        $opinion4->setAuthor('Manuel Penichet');
        $opinion4->setCity('San Sebastian');

        $opinion5 = new Opinions();
        $opinion5->setComent('El sabio no se sienta para lamentarse, sino que se pone alegremente a su tarea de reparar el daño hecho');
        $opinion5->setAuthor('William Shakespeare');
        $opinion5->setCity('Londres');

        $doctrine->persist($opinion1);
        $doctrine->persist($opinion2);
        $doctrine->persist($opinion3);
        $doctrine->persist($opinion4);
        $doctrine->persist($opinion5);

        $doctrine->flush();

        return new Response("Opiniones insertadas correctamente");

    }

    // Ruta creada para mostrar todas las solicitudes de Demo
    #[Route('/maleteo/solicitudes', name:'demosList')]
    public function allDemosRequest (EntityManagerInterface $doctrine) {

        $repositorio = $doctrine->getRepository(Demo::class);
        $demos = $repositorio->findAll();

        return $this-> render('/maleteo/demosList.html.twig', ['demos' => $demos]); 

    }

    // Ruta creada para insertar opiniones de los Guardianes
    #[Route('/maleteo/opiniones', name: 'maleteoOpinions')]
    public function newOpinion(Request $request, EntityManagerInterface $doctrine) {

        $form = $this->createForm(GuardianType::class);
        $form->handleRequest($request);

        if ($form-> isSubmitted() && $form-> isValid()) {
            $opinion = $form-> getData();
            $doctrine-> persist($opinion);
            $doctrine-> flush();
            $this-> addFlash('success', 'Opinion insertada correctamente!!');
            return $this-> redirectToRoute('maleteo');

        }

        return $this->renderForm('maleteo/newOpinion.html.twig', ['opinionForm'=> $form]);

    }

}  