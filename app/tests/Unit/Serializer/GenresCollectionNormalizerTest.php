<?php

namespace App\Tests\Unit\Serializer;

use App\Http\Model\Genre;
use App\Serializer\GenresCollectionNormalizer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class GenresCollectionNormalizerTest extends TestCase
{
    private GenresCollectionNormalizer $normalizer;
    private DenormalizerInterface $denormalizerMock;

    protected function setUp(): void
    {
        $this->denormalizerMock = $this->createMock(DenormalizerInterface::class);
        $this->normalizer = new GenresCollectionNormalizer();
        $this->normalizer->setDenormalizer($this->denormalizerMock);
    }

    public function testSupportsDenormalization(): void
    {
        $context =  ['normalization' => 'GENRES_COLLECTION_NORMALIZATION'];
        $this->assertTrue($this->normalizer->supportsDenormalization([], Genre::class . '[]', null, $context));
    }

    public function testDoesNotSupportDenormalization(): void
    {
        $context = [];
        $this->assertFalse($this->normalizer->supportsDenormalization([], Genre::class . '[]', null, $context));
    }

    public function testDenormalize(): void
    {
        $data = ['genres' => [['id' => 1, 'name' => 'Action']]];
        $context = [];

        $this->denormalizerMock
            ->expects($this->once())
            ->method('denormalize')
            ->with($data['genres'], Genre::class . '[]', null, $context)
            ->willReturn([$data['genres']]);

        $result = $this->normalizer->denormalize($data, Genre::class . '[]', null, $context);
        $this->assertEquals([$data['genres']], $result);
    }
}