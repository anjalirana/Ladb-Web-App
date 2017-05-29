<?php

namespace RaceBundle\Controller;

use Circle\RestClientBundle\Exceptions\OperationTimedOutException;
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
        $raceData = $this->makeGetCall('/api/raceDetail?code=' . $raceCode);

        if ($raceData->getStatusCode() === 404) {
            $raceContent = null;
        } else {
            $raceContent = $raceData->getContent();
        }

        return $this->render('default/raceDetail.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'race' => json_decode($raceContent)
        ]);
    }

    /**
     * @return RestClient $restClient
     */

    protected  function getRestClient()
    {
        $restClient = $this->container->get('circle.restclient');

        return $restClient;
    }

    protected function makeGetCall($endpoint)
    {
        $apiUrl = $this->container->getParameter('ladb_api_url');
        $restClient = $this->getRestClient();

        try {
            return $restClient->get($apiUrl. $endpoint);
        } catch (OperationTimedOutException $exception) {
            throw new OperationTimedOutException();
        }
    }
}
