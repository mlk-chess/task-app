<?php

namespace App\Story;

use Zenstruck\Foundry\Story;
use App\Factory\UserFactory;

final class DefaultUserStory extends Story
{
    public function build(): void
    {
        // TODO build your story here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#stories)
        UserFactory::createMany(200);

    }
}
