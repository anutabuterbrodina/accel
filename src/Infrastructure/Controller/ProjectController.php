<?php

namespace App\Infrastructure\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectController
{
    public function __construct(
//        private readonly int $authorizationService,
//        private readonly int $authenticationService,
    ) {}

    public function get(Request $request): Response
    {
//        $this->authorizationService;
//
//        $this->postQuery
//            ->includeAuthor()
//            ->includeTags()
//            ->execute(new PostId($request->getAttribute('id')))
//            ->hydrateSingleResultAs(GetViewModel::class);
    }

    public function updateStatus()
    {

    }
}
