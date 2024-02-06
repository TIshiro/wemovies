<?php

namespace App\Serializer;

use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;

class BaseNormalizer
{
    public const NORMALIZATION_CONTEXT_KEY = 'normalization';
    public const GENRES_COLLECTION_NORMALIZATION_CONTEXT = 'GENRES_COLLECTION_NORMALIZATION';
    public const MOVIES_COLLECTION_NORMALIZATION_CONTEXT = 'MOVIES_COLLECTION_NORMALIZATION';
    public const MOVIE_DETAILS_NORMALIZATION_CONTEXT = 'MOVIE_DETAILS_NORMALIZATION';

    use DenormalizerAwareTrait;
}