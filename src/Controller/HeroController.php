<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Hero;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
class HeroController extends AbstractController

{

    /**
     * @Route("/ViewHeroes", name="get")
     *   Method ({"GET")
     */

    public function getHero(Request $request): Response
    {
        $heroRepository = $this->getDoctrine()->getRepository(Hero::class);
        $items = $heroRepository->findAll();
        $arrayHeroes  = array();
        foreach ($items  as $hero) {
            $arrayHeroes[] = array(
                'nickname' => $hero->getNickname(),
                'real_name' => $hero->getRealName(),
                'origin_description' => $hero->getOriginDescription(),
                'superpowers' => $hero->getSuperpowers(),
                'catch_phrase' => $hero->getCatchPhrase(),
                'fileName' => $hero->getHeroImage(),
                'id' => $hero->getId()
            );
        }
        $response = new JsonResponse();
        $response->setContent(json_encode($arrayHeroes));
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;

    }


    /**
     * @Route("/api/create", name="create")
     *  Method ({"POST")
     */

    public function createHero(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $hero = new Hero();
        $hero->setNickname($request->request->get('nickname'));
        $hero->setRealName($request->request->get('real_name'));
        $hero->setOriginDescription($request->request->get('origin_description'));
        $hero->setSuperpowers($request->request->get('superpowers'));
        $hero->setCatchPhrase($request->request->get('catch_phrase'));
        $hero->setHeroImage('fileName');
        $entityManager->persist($hero);
        $entityManager->flush();

        $heroRepository = $this->getDoctrine()->getRepository(Hero::class);
        $allHeroes = $heroRepository->findAll();
        $arrayHeroes  = array();
        foreach ($allHeroes  as $hero) {
            $arrayHeroes[] = array(
                'nickname' => $hero->getNickname(),
                'real_name' => $hero->getRealName(),
                'origin_description' => $hero->getOriginDescription(),
                'superpowers' => $hero->getSuperpowers(),
                'catch_phrase' => $hero->getCatchPhrase(),
                'fileName' => $hero->getHeroImage(),

            );
        }
        $response = new JsonResponse();
        $response->setContent('success');
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;


    }

    /**
     * @Route("/api/update", name="update")
     *  Method ({"POST")
     */

    public function updateHero(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $id = $request->request->get('id');
        $heroRepository = $this->getDoctrine()->getRepository(Hero::class);
        $hero = $heroRepository->find($id);
        $hero->setNickname($request->request->get('nickname'));
        $hero->setRealName($request->request->get('real_name'));
        $hero->setOriginDescription($request->request->get('origin_description'));
        $hero->setSuperpowers($request->request->get('superpowers'));
        $hero->setCatchPhrase($request->request->get('catch_phrase'));
        $hero->setHeroImage('fileName');
        $entityManager->flush();
        $response = new JsonResponse();
        $response->setContent('success');
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;

    }

    /**
     * @Route("/api/delete/", name="delete")
     *   Method ({"DELETE")
     */

    public function deleteHero(Request $request): Response
    {
        $id = $request->query->get('id');
        $heroRepository = $this->getDoctrine()->getRepository(Hero::class);
        $hero = $heroRepository->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($hero);
        $entityManager->flush();
        $response = new JsonResponse();
        $response->setContent('success');
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }
}
