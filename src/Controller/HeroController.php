<?php

namespace App\Controller;

use mysql_xdevapi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Hero;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Tools\Pagination\Paginator;

class HeroController extends AbstractController

{

    /**
     * @Route("/ViewHeroes", name="get")
     *   Method ({"GET")
     */

    public function getHero(Request $request): Response
    {
        $response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        $page = json_decode($request->query->get('page'), true);
        if (!$page && !is_numeric($page)) {
            $response->setContent('not valid page param');
            $response->setStatusCode(404);
            return $response;
        };


        $endIndex = $page * 5;
        $beginIndex = $endIndex - 5;
        $entityManager = $this->getDoctrine()->getManager();
        $dql = "SELECT p FROM App\Entity\Hero p";
        $query = $entityManager->createQuery($dql)
            ->setFirstResult($beginIndex)
            ->setMaxResults($endIndex);
        $paginator = new Paginator($query, $fetchJoinCollection = true);
        $c = count($paginator);
        $arrayHeroes = array();


        foreach ($paginator as $hero) {
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

        if (empty($arrayHeroes)) {
            $response->setContent('no content');
            $response->setStatusCode(204);
            return $response;
        };

        $response->setContent(json_encode(['arrayHeroes' => $arrayHeroes, 'totalPages' => $c]));
        return $response;
    }

    /**
     * @Route("/api/create", name="create")
     *  Method ({"POST")
     */

    public function createHero(Request $request): Response
    {
        $response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');


        $data = json_decode($request->getContent(), true);
        dump($data);die;
        $entityManager = $this->getDoctrine()->getManager();
        $hero = new Hero();
        $hero->setNickname($data["nickname"]);
        $hero->setRealName($data["real_name"]);
        $hero->setOriginDescription($data["origin_description"]);
        $hero->setSuperpowers($data["superpowers"]);
        $hero->setCatchPhrase($data["catch_phrase"]);
        $hero->setHeroImage('fileName');
        $entityManager->persist($hero);
        $entityManager->flush();
        $response->setContent('success');
        $response->setStatusCode(201);
        return $response;
    }

    /**
     * @Route("/api/update", name="update")
     *  Method ({"PUT")
     */

    public function updateHero(Request $request): Response
    {
        $response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        $data = json_decode($request->getContent(), true);
        $entityManager = $this->getDoctrine()->getManager();

        if (!array_key_exists("id", $data)) {
            $response->setContent('not valid id');
            $response->setStatusCode(404);
            return $response;
        }
        $id = $data["id"];
        $heroRepository = $this->getDoctrine()->getRepository(Hero::class);
        $hero = $heroRepository->find($id);
        $hero->setNickname($data["nickname"]);
        $hero->setRealName($data["real_name"]);
        $hero->setOriginDescription($data["origin_description"]);
        $hero->setSuperpowers($data["superpowers"]);
        $hero->setCatchPhrase($data["catch_phrase"]);
        $hero->setHeroImage('fileName');
        $entityManager->flush();
        $response->setContent('success');
        return $response;


    }

    /**
     * @Route("/api/delete/", name="delete")
     *   Method ({"DELETE")
     */

    public function deleteHero(Request $request): Response
    {
        $response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        $id = $request->query->get('id');
        $heroRepository = $this->getDoctrine()->getRepository(Hero::class);
        $hero = $heroRepository->find($id);
        if (!$hero) {
            $response->setContent('not valid id');
            $response->setStatusCode(404);
            return $response;
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($hero);
        $entityManager->flush();
        $response->setContent('success');
        return $response;


    }
}