<?php

namespace AppBundle\Controller;

use Circle\RestClientBundle\Services\RestClient;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {
        $type = $request->get('type');
        /** @var RestClient $restClient */
        $restClient = $this->container->get('circle.restclient');

        $types = $restClient->get('http://127.0.0.1:8000/api/types');
        $races = $restClient->get('http://127.0.0.1:8000/api?type=' . $type);

        var_dump($races);die;

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'types' => json_decode($types->getContent()),
            'races' => json_decode($races->getContent())
        ]);
    }

    public function raceDetailAction(Request $request)
    {
        $raceCode = $request->get('code');

        /** @var RestClient $restClient */
        $restClient = $this->container->get('circle.restclient');

        $raceData = $restClient->get('http://127.0.0.1:8000/api/raceDetail?code=' . $raceCode);

        return $this->render('default/raceDetail.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'raceDate' => json_decode($raceData->getContent())
        ]);

    }
}
