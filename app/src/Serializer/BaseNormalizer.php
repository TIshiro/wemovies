<?php

namespace App\Serializer;

use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class BaseNormalizer
{
    public const NORMALIZATION_CONTEXT_KEY = 'normalization';
    public const GENRES_COLLECTION_NORMALIZATION_CONTEXT = 'GENRES_COLLECTION_NORMALIZATION';
    public const MOVIES_COLLECTION_NORMALIZATION_CONTEXT = 'MOVIES_COLLECTION_NORMALIZATION';
    public const VIDEOS_COLLECTION_NORMALIZATION_CONTEXT = 'VIDEOS_COLLECTION_NORMALIZATION';

    use DenormalizerAwareTrait;
}