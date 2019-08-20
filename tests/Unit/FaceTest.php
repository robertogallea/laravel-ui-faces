<?php


namespace Tests\Unit;


use robertogallea\UIFaces\Face;
use Tests\TestCase;

class FaceTest extends TestCase
{
    /** @test */
    public function it_has_data()
    {
        $face = new Face(
            $name = 'name',
            $email = 'email',
            $position = 'position',
            $photoUrl = 'http://image-url'
        );

        $this->assertEquals($name, $face->getName());
        $this->assertEquals($email, $face->getEmail());
        $this->assertEquals($position, $face->getPosition());
        $this->assertEquals($photoUrl, $face->getPhotoUrl());
    }

    /** @test */
    public function it_can_set_data()
    {
        $face = new Face();

        $face->setName($name = 'name');
        $face->setEmail($email = 'email');
        $face->setPosition($position = 'position');
        $face->setPhotoUrl($photoUrl = 'http://image-url');

        $this->assertEquals($name, $face->getName());
        $this->assertEquals($email, $face->getEmail());
        $this->assertEquals($position, $face->getPosition());
        $this->assertEquals($photoUrl, $face->getPhotoUrl());
    }
}