<?php

namespace App\Http\Model;



use Symfony\Component\Serializer\Annotation\Groups;

class Video
{
    public string $id;
    public string $name;
    public string $key;

    public static function from(string $id, string $name, string $key): self
    {
        $obj =  new self();
        $obj->id = $id;
        $obj->name = $name;
        $obj->key = $key;
        return $obj;
    }
}