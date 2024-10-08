<?php

namespace App\Serializer;

use App\Http\Model\Video;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class VideosCollectionNormalizer extends BaseNormalizer implements DenormalizerInterface, DenormalizerAwareInterface
{

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        unset($context[BaseNormalizer::NORMALIZATION_CONTEXT_KEY]);
        $youTubeVideos = $this->getYouTubeVideos($data['results'] ?? []);

        return $this->denormalizer->denormalize($youTubeVideos, $type, $format, $context);
    }
    private function getYouTubeVideos(array $videos): array
    {
        return array_filter($videos, fn($video) => $video['site'] === 'YouTube' && in_array($video['type'], ['Teaser', 'Trailer']));
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return isset($context[BaseNormalizer::NORMALIZATION_CONTEXT_KEY]) &&
            BaseNormalizer::VIDEOS_COLLECTION_NORMALIZATION_CONTEXT === $context[BaseNormalizer::NORMALIZATION_CONTEXT_KEY] &&
            Video::class . '[]' === $type
            ;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            Video::class . '[]' => false,
        ];
    }
}