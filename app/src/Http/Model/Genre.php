<?php

namespace App\Http\Model;

class Genre
{
    public int $id;
    public string $name;

    public static function from(int $id, string $name): self
    {
        $obj =  new self();
        $obj->id = $id;
        $obj->name = $name;
        return $obj;
    }
}