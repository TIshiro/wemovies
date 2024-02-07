<?php

namespace App\Http\Model;

use Symfony\Component\Serializer\Annotation\SerializedName;

class Movie
{
    public int $id;
    public string $title;
    public string $overview;
    #[SerializedName('poster_path')]
    public ?string $posterPath;
    #[SerializedName('vote_average')]
    public float $voteAverage;
    #[SerializedName('vote_count')]
    public int $voteCount;
    #[SerializedName('release_date')]
    public ?string $releaseDate;

    public static function from(int $id, string $title, string $overview, float $voteAverage, int $voteCount,?string $releaseDate, ?string $posterPath): self
    {
        $obj = new self();
        $obj->id = $id;
        $obj->title = $title;
        $obj->overview = $overview;
        $obj->voteAverage = $voteAverage;
        $obj->voteCount = $voteCount;
        $obj->releaseDate = $releaseDate;
        $obj->posterPath = $posterPath;
        return $obj;
    }
}