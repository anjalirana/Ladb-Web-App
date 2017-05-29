<?php

namespace RaceBundle\Controller;

use Circle\RestClientBundle\Exceptions\OperationTimedOutException;
use Circle\RestClientBundle\Services\RestClient;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $type = $request->get('type');

        $types = $this->makeGetCall('/api/types');

        $races = $this->makeGetCall('/api?type=' . $type);

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'types' => $this->getJsonDecoded($types->getContent()),
            'races' => $this->getJsonDecoded($races->getContent())
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

    protected function getJsonDecoded($content)
    {
        return json_decode($content);
    }
}
