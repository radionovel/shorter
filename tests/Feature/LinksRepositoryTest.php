<?php

namespace Tests\Feature;

use App\Repositories\LinksRepository;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LinksRepositoryTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithDatabase;
}
