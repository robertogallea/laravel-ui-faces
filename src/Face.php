<?php


namespace robertogallea\UIFaces;


class Face
{
    protected $name;

    protected $email;

    protected $position;

    protected $photoUrl;

    public function __construct($name = null, $email = null, $position = null, $photoUrl = null)
    {
        $this->name = $name;
        $this->email = $email;
        $this->position = $position;
        $this->photoUrl = $photoUrl;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function getPhotoUrl()
    {
        return $this->photoUrl;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position): void
    {
        $this->position = $position;
    }

    /**
     * @param mixed $photoUrl
     */
    public function setPhotoUrl($photoUrl): void
    {
        $this->photoUrl = $photoUrl;
    }


}