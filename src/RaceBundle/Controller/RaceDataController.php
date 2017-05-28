<?php

namespace RaceBundle\Controller;

use Circle\RestClientBundle\Services\RestClient;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RaceDataController extends Controller
{
    /**
     * @Route("/raceDetail", name="raceData")
     */
    public function indexAction(Request $request)
    {
        $raceCode = $request->get('code');

        /** @var RestClient $restClient */
        $restClient = $this->container->get('circle.restclient');

        $raceData = $restClient->get('http://127.0.0.1:8000/api/raceDetail?code=' . $raceCode);

        return $this->render('default/raceDetail.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'race' => json_decode($raceData->getContent())
        ]);
    }
}
