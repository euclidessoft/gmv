<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Bundle\SecurityBundle\Security;
// use Doctrine\ORM\EntityManagerInterface;


class AccueilController extends AbstractController
{
    //   public function __construct(private Security $security, private EntityManagerInterface $entityManager)
    // {
    // }

    #[Route("/", name :"Accu") ]
    public function acc(Request $request)
    {
        return  $this->redirectToRoute('Accueil');
    }
    
    #[Route("/{_locale}/", name :"Accueil") ]
    public function accueil(Request $request)
    {
        return  $this->render('website/accueil.html.twig');
    }
    #[Route("/{_locale}/About", name :"About") ]
    public function about(Request $request)
    {
        return  $this->render('website/about.html.twig');
    }

    #[Route("/{_locale}/Logistique", name :"Logistique") ]
    public function planning(Request $request)
    {
        return  $this->render('website/logistique.html.twig');
    }
    #[Route("/{_locale}/Conditions", name :"Conditions") ]
    public function condition(Request $request)
    {
        return  $this->render('website/condition.pdf');
    }

    #[Route("/{_locale}/Distribution", name :"Distribution") ]
    public function improve(Request $request)
    {
        return  $this->render('website/distribution.html.twig');
    }

    #[Route("/{_locale}/Promotion", name :"Promotion") ]
    public function securite(Request $request)
    {
        return  $this->render('website/promotion.html.twig');
    }

    #[Route("/{_locale}/Actualite", name :"Actualite") ]
    public function actualite(Request $request)
    {
        return  $this->render('website/actualite.html.twig');
    }

    #[Route("/{_locale}/Contact", name :"Contact") ]
    public function contact(Request $request)
    {
        return  $this->render('website/contact.html.twig');
    }

    #[Route("/{_locale}/Carriere", name :"Carriere") ]
    public function realisations(Request $request)
    {
        $candidature =  new Candidature();
        $form = $this->createForm(CandidatureType::class, $candidature);
        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if($form->isValid())
            {
                $em = $this->entityManager;
                $candidature->getCv()->upload($candidature);
                $em->persist($candidature);
                $em->flush();
                $this->addFlash('notice', 'Candidature enregistrée avec succée');
                return $this->redirectToRoute('Carriere');
            }
        }
        return  $this->render('website/carrieres.html.twig',
            [
                'form' => $form->createView(),
            ]);
    }

    #[Route("/{_locale}/Gallery-photo", name :"Gallery_photo") ]
    public function photo(Request $request)
    {
        $albums = $this->entityManager->getRepository(Album::class)->findAll();
        return  $this->render('website/galleryphoto.html.twig',[
            'albums' => $albums,
        ]);
    }

    #[Route("/{_locale}/Gallery/Photo/Album/{album}", name :"Gallery_photo_album_view") ]
    public function photo_reservoir(Request $request, Album $album, ImageRepository $repository)
    {
        return  $this->render('website/reservoir.html.twig',[
            'album' => $album,
            'images' => $repository->findBy(['album' => $album]),
        ]);
    }

}
