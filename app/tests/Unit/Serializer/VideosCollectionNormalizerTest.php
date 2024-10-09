<?php

namespace App\Tests\Unit\Serializer;

use App\Http\Model\Video;
use App\Serializer\VideosCollectionNormalizer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class VideosCollectionNormalizerTest extends TestCase
{
    private VideosCollectionNormalizer $normalizer;
    private DenormalizerInterface $denormalizerMock;

    protected function setUp(): void
    {
        $this->denormalizerMock = $this->createMock(DenormalizerInterface::class);
        $this->normalizer = new VideosCollectionNormalizer();
        $this->normalizer->setDenormalizer($this->denormalizerMock);
    }

    public function testSupportsDenormalization(): void
    {
        $context = ['normalization' => 'VIDEOS_COLLECTION_NORMALIZATION'];
        $this->assertTrue($this->normalizer->supportsDenormalization([], Video::class . '[]', null, $context));
    }

    public function testDoesNotSupportDenormalization(): void
    {
        $context = [];
        $this->assertFalse($this->normalizer->supportsDenormalization([], Video::class . '[]', null, $context));
    }

    public function testDenormalize(): void
    {
        $data = ['results' => [['site' => 'YouTube', 'type' => 'Trailer', 'id' => 1]]];
        $context = [];

        $filteredData = [['site' => 'YouTube', 'type' => 'Trailer', 'id' => 1]];

        $this->denormalizerMock
            ->expects($this->once())
            ->method('denormalize')
            ->with($filteredData, Video::class . '[]', null, $context)
            ->willReturn([$filteredData]);

        $result = $this->normalizer->denormalize($data, Video::class . '[]', null, $context);
        $this->assertEquals([$filteredData], $result);
    }

    public function testDenormalizeFiltersNonYouTubeTrailerOrTeaserVideos(): void
    {
        $data = [
            'results' => [
                ['site' => 'Vimeo', 'type' => 'Trailer', 'id' => '1'],
                ['site' => 'YouTube', 'type' => 'Teaser', 'id' => '2'],
                ['site' => 'YouTube', 'type' => 'Clip', 'id' => '3'],
                ['site' => 'YouTube', 'type' => 'Trailer', 'id' => '4']
            ]
        ];

        $filteredData = [
            1 => ['site' => 'YouTube', 'type' => 'Teaser', 'id' => '2'],
            3 => ['site' => 'YouTube', 'type' => 'Trailer', 'id' => '4'],
        ];
        $context = [];

        $this->denormalizerMock
            ->expects($this->once())
            ->method('denormalize')
            ->with($filteredData, Video::class . '[]', null, $context)
            ->willReturn([$filteredData]);

        $result = $this->normalizer->denormalize($data, Video::class . '[]', null, $context);
        $this->assertEquals([$filteredData], $result);
    }
}