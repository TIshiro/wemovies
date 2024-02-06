<?php

namespace App\Serializer;

use App\Http\Model\Movie;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class MoviesCollectionNormalizer extends BaseNormalizer implements DenormalizerInterface, DenormalizerAwareInterface
{

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        unset($context[BaseNormalizer::NORMALIZATION_CONTEXT_KEY]);
        return $this->denormalizer->denormalize($data['results'] ?? [], $type, $format, $context);
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return isset($context[BaseNormalizer::NORMALIZATION_CONTEXT_KEY]) &&
            BaseNormalizer::MOVIES_COLLECTION_NORMALIZATION_CONTEXT === $context[BaseNormalizer::NORMALIZATION_CONTEXT_KEY] &&
            Movie::class . '[]' === $type
            ;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            Movie::class . '[]' => false,
        ];
    }
}