<?php

namespace App\Tests\Unit\Serializer;

use App\Http\Model\Movie;
use App\Serializer\MoviesCollectionNormalizer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class MoviesCollectionNormalizerTest extends TestCase
{
    private MoviesCollectionNormalizer $normalizer;
    private DenormalizerInterface $denormalizerMock;

    protected function setUp(): void
    {
        $this->denormalizerMock = $this->createMock(DenormalizerInterface::class);
        $this->normalizer = new MoviesCollectionNormalizer();
        $this->normalizer->setDenormalizer($this->denormalizerMock);
    }

    public function testSupportsDenormalization(): void
    {
        $context = ['normalization' => 'MOVIES_COLLECTION_NORMALIZATION'];
        $this->assertTrue($this->normalizer->supportsDenormalization([], Movie::class . '[]', null, $context));
    }

    public function testDoesNotSupportDenormalization(): void
    {
        $context = [];
        $this->assertFalse($this->normalizer->supportsDenormalization([], Movie::class . '[]', null, $context));
    }

    public function testDenormalize(): void
    {
        $data = ['results' => [['id' => 1, 'title' => 'Inception']]];
        $context = [];

        $this->denormalizerMock
            ->expects($this->once())
            ->method('denormalize')
            ->with($data['results'], Movie::class . '[]', null, $context)
            ->willReturn([$data['results']]);

        $result = $this->normalizer->denormalize($data, Movie::class . '[]', null, $context);
        $this->assertEquals([$data['results']], $result);
    }
}