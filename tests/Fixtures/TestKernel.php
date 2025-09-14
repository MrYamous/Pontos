<?php

namespace Yamous\InspectDatabaseBundle\Tests\Fixtures;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;
use Yamous\InspectDatabaseBundle\InspectDatabaseBundle;

final class TestKernel extends Kernel
{
    public function registerBundles(): array
    {
        return [
            new FrameworkBundle(),
            new DoctrineBundle(),
            new InspectDatabaseBundle(),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load(__DIR__ . '/config/test_config.yaml');
    }

    public function getProjectDir(): string
    {
        return __DIR__ . '/../../';
    }
}