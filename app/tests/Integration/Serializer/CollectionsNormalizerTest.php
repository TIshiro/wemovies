<?php

namespace App\Tests\Integration\Serializer;

use App\Http\Model\Genre;
use App\Http\Model\Movie;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Serializer\SerializerInterface;

class CollectionsNormalizerTest extends KernelTestCase
{
    private SerializerInterface $serializer;
    protected function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $this->serializer = $container->get(SerializerInterface::class);
    }

    public function testDenormalizeGenres(): void
    {
        $data ='{"genres": [{"id": 28,"name": "Action"},{"id": 12,"name": "Adventure"},{"id": 16,"name": "Animation"}]}';
        $expectedResult = [
            Genre::from(28, "Action"),
            Genre::from(12, "Adventure"),
            Genre::from(16, "Animation"),
        ];

        $this->assertEquals(
            $expectedResult,
            $this->serializer->deserialize($data, Genre::class . '[]', 'json', ['normalization' => 'GENRES_COLLECTION_NORMALIZATION'])
        );
    }

    public function testDenormalizeMovies(): void
    {
        $data =file_get_contents(__DIR__.'/Dummies/movies.json');
        $expectedResult = [
            Movie::from(
                866398,
                "The Beekeeper",
                "One man’s campaign for vengeance takes on national stakes after he is revealed to be a former operative of a powerful and clandestine organization known as Beekeepers.",
                7.4,
                634,
                "2024-01-10",
                "/A7EByudX0eOzlkQ2FIbogzyazm2.jpg"
            ),
            Movie::from(
                933131,
                "Badland Hunters",
                "After a deadly earthquake turns Seoul into a lawless badland, a fearless huntsman springs into action to rescue a teenager abducted by a mad doctor.",
                7.099,
                171,
                "2024-01-26",
                "/zVMyvNowgbsBAL6O6esWfRpAcOb.jpg"
            ),
        ];

        $this->assertEquals(
            $expectedResult,
            $this->serializer->deserialize($data, Movie::class . '[]', 'json', ['normalization' => 'MOVIES_COLLECTION_NORMALIZATION'])
        );
    }
}
