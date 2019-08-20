<?php


namespace robertogallea\UIFaces;


use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;

class UIFaces
{
    protected $apiUrl;

    protected $apiKey;

    protected $handler;

    protected $parameters = [
        'limit',
        'offset',
        'random',
        'from_age',
        'to_age',
    ];

    protected $arrayParameters = [
        'gender',
        'hairColor',
        'emotion'
    ];

    protected $parameterString = '';

    public function __construct($apiUrl = null, $apiKey = null)
    {
        $this->apiUrl = $apiUrl;
        $this->apiKey = $apiKey;
    }

    public function getApiUrl()
    {
        return $this->apiUrl;
    }

    public function getApiKey()
    {
        return $this->apiKey;
    }

    public function setClientHandler(HandlerStack $handler)
    {
        $this->handler = $handler;
    }

    public function getFaces()
    {
        $config = [];

        if ($this->handler) {
            $config = array_merge($config, ['handler' => $this->handler]);
        }

        $client = new Client($config);

        $json_faces = $this->makeApiRequest($client);

        $faces = $this->collectFaces($json_faces);

        return $faces;
    }

    public function parseFace(array $jsonFace)
    {
        return new Face(
            $jsonFace['name'],
            $jsonFace['email'],
            $jsonFace['position'],
            $jsonFace['photo'],
        );
    }

    public function __call($name, $arguments)
    {
        if ($this->hasParameter($name)) {
            $this->concatenateParameter($name, $arguments);

            return $this;
        }

        if ($this->hasParameterArray($name)) {
            $this->concatenateParameterArray($name, $arguments);

            return $this;
        }
    }

    public function getParametersString()
    {
        return $this->parameterString;
    }

    public function reset()
    {
        $this->parameterString = '';

        return $this;
    }

    private function addPrefixToParameterString(): void
    {
        if ($this->parameterString == '') {
            $this->parameterString = '?';
        } else {
            $this->parameterString .= '&';
        }
    }

    /**
     * @param $name
     * @return bool
     */
    private function hasParameter($name): bool
    {
        return in_array($name, $this->parameters);
    }

    /**
     * @param $name
     * @return bool
     */
    private function hasParameterArray($name): bool
    {
        return in_array($name, $this->arrayParameters);
    }

    /**
     * @param $name
     * @param $arguments
     */
    private function concatenateParameter($name, $arguments): void
    {
        $this->addPrefixToParameterString();
        $this->parameterString .= $name . '=' . $arguments[0];
    }

    /**
     * @param $name
     * @param $arguments
     */
    private function concatenateParameterArray($name, $arguments): void
    {
        $this->addPrefixToParameterString();
        $this->parameterString .= $name . '[]=' . $arguments[0];
    }

    /**
     * @param Client $client
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function makeApiRequest(Client $client)
    {
        $json_faces = json_decode($client->request('GET', 'https://uifaces.co/api' . $this->parameterString, [
            'headers' => [
                'X-API-KEY' => $this->apiKey,
                'Accept' => 'application/json',
            ]])->getBody(), true);
        return $json_faces;
    }

    /**
     * @param $json_faces
     * @return array
     */
    private function collectFaces($json_faces): array
    {
        $faces = [];
        foreach ($json_faces as $json_face) {
            $faces[] = $this->parseFace($json_face);
        }
        return $faces;
    }
}