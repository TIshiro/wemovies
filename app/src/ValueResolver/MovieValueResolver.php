<?php

namespace App\ValueResolver;

use App\Http\Model\Movie;
use App\Http\TheMovieDB;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class MovieValueResolver implements ValueResolverInterface
{
    public function __construct(private TheMovieDB $theMovieDB)
    {
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        return $this->supports($argument) ?  $this->apply($request) : [];
    }

    private function supports(ArgumentMetadata $argument): bool
    {
        return $argument->getType() === Movie::class;
    }

    private function apply(Request $request): array
    {
        $id = $request->attributes->get('id');
        $movie = $this->theMovieDB->movie($id);
        if (!$movie instanceof Movie) {
            throw new NotFoundHttpException();
        }
        return [$movie];
    }
}