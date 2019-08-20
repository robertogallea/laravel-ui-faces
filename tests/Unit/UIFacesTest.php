<?php

namespace Tests\Unit;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use robertogallea\UIFaces\UIFaces;
use Tests\TestCase;

class UIFacesTest extends TestCase
{
    /** @test */
    public function it_can_retrieve_api_url_from_configuration()
    {
        $uifaces = new UIFaces($apiUrl = 'http://apiurl.com', 'def');

        $this->assertEquals('http://apiurl.com', $uifaces->getApiUrl());
    }

    /** @test */
    public function it_can_retrieve_api_token_from_configuration()
    {
        $uifaces = new UIFaces('http://apiurl.com', $apiKey = 'def');

        $this->assertEquals($apiKey, $uifaces->getApiKey());
    }

    /** @test */
    public function it_can_load_faces_from_api()
    {
        $mock = new MockHandler([
            new Response(200, [], \GuzzleHttp\json_encode([
                [
                    "name" => $name = "Name",
                    "email" => $email = "email@email.it",
                    "position" => $position = "Position",
                    "photo" => $photo = "https://photo.url"
                ],
            ])),
        ]);

        $handler = HandlerStack::create($mock);


        $uifaces = new UIFaces('http://apiurl.com', $apiKey = 'def');

        $uifaces->setClientHandler($handler);

        $faces = $uifaces->getFaces();

        $this->assertEquals($name, $faces[0]->getName());
    }

    /** @test */
    public function it_can_parse_json_faces()
    {
        $jsonFace = [
            "name" => $name = "Name",
            "email" => $email = "email@email.it",
            "position" => $position = "Position",
            "photo" => $photo = "https://photo.url"
        ];

        $uifaces = new UIFaces();

        $face = $uifaces->parseFace($jsonFace);

        $this->assertEquals($face->getName(), $name);
        $this->assertEquals($face->getEmail(), $email);
        $this->assertEquals($face->getPosition(), $position);
        $this->assertEquals($face->getPhotoUrl(), $photo);
    }

    /** @test */
    public function it_can_set_parameters()
    {
        $uifaces = new UIFaces();

        $uifaces->limit(10)->from_age(18)->to_age(22)->emotion('sadness');

        $this->assertEquals('?limit=10&from_age=18&to_age=22&emotion[]=sadness', $uifaces->getParametersString());
    }

    /** @test */
    public function it_can_reset_parameters()
    {
        $uifaces = new UIFaces();

        $uifaces->limit(10)->reset()->limit(12);

        $this->assertEquals('?limit=12', $uifaces->getParametersString());
    }

    /** @test */
    public function it_returns_empty_array_if_no_faces_are_returned()
    {
        $mock = new MockHandler([
            new Response(200, [], '[]'),
        ]);

        $handler = HandlerStack::create($mock);


        $uifaces = new UIFaces('http://apiurl.com', $apiKey = 'def');

        $uifaces->setClientHandler($handler);

        $faces = $uifaces->getFaces();

        $this->assertCount(0, $faces);
    }
}