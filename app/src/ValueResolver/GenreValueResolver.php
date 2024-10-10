<?php

namespace App\ValueResolver;

use App\Http\Model\Genre;
use App\Http\TheMovieDB;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class GenreValueResolver implements ValueResolverInterface
{
    public function __construct(private TheMovieDB $theMovieDB)
    {
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        return $this->supports($argument) ?  $this->apply($request) : [];
    }

    private function apply(Request $request): array
    {
        $id = $request->attributes->get('id');
        $genre = $this->theMovieDB->genre($id);
        if (!$genre) {
            throw new NotFoundHttpException('Genre not found.');
        }
        return [$genre];
    }

    private function supports(ArgumentMetadata $argument): bool
    {
        return $argument->getType() === Genre::class;
    }
}