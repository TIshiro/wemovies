<?php

namespace App\Http\Model;



use Symfony\Component\Serializer\Annotation\Groups;

class Video
{
    public string $id;
    public string $name;
    public string $key;
}