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
}