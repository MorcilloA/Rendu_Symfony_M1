<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

abstract class AbstractDataFixtures
{
    const CATEGORIES = [
        'animals' => [
            'bear',
            'bird',
            'bulldog',
        ],
        'actions' => [
            'breaking up',
            'cooking',
            'crying',
        ]
        ];
}