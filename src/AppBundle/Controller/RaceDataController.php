<?php

namespace AppBundle\Controller;

use Circle\RestClientBundle\Services\RestClient;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RaceDataController extends Controller
{

    public function raceAction(Request $request)
    {
        $raceCode = $request->get('code');

        /** @var RestClient $restClient */
        $restClient = $this->container->get('circle.restclient');

        $raceData = $restClient->get('http://127.0.0.1:8000/api/raceDetail?code=' . $raceCode);

        var_dump($raceData);die;

        return $this->render('default/raceDetail.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'raceData' => json_decode($raceData->getContent())
        ]);
    }
}
