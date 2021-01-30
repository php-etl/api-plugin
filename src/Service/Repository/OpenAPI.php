<?php declare(strict_types=1);

namespace Kiboko\Plugin\API\Service\Repository;

use Jane\Component\JsonSchema\Registry\Registry;
use Kiboko\Contract\Configurator;
use Kiboko\Plugin\API;

final class OpenAPI implements Configurator\RepositoryInterface
{
    /** @var Configurator\FileInterface[] */
    private array $files;
    /** @var string[] */
    private array $packages;

    public function __construct(
        private API\Builder\OpenAPI $builder,
        Registry ...$registries,
    ) {
        $this->files = [];
        $this->packages = [];

        foreach ($registries as $jane) {
            foreach ($jane->getSchemas() as $schema) {
                foreach ($schema->getFiles() as $file) {
                    $this->addFiles(
                        new File($file->getFilename(), $file->getNode()),
                    );
                }
            }
        }
    }

    public function addFiles(Configurator\FileInterface ...$files): Configurator\RepositoryInterface
    {
        array_push($this->files, ...$files);

        return $this;
    }

    /** @return iterable<Configurator\FileInterface> */
    public function getFiles(): iterable
    {
        return $this->files;
    }

    public function addPackages(string ...$packages): Configurator\RepositoryInterface
    {
        array_push($this->packages, ...$packages);

        return $this;
    }

    /** @return iterable<string> */
    public function getPackages(): iterable
    {
        return $this->packages;
    }

    public function getBuilder(): API\Builder\OpenAPI
    {
        return $this->builder;
    }

    public function merge(Configurator\RepositoryInterface $friend): Configurator\RepositoryInterface
    {
        array_push($this->files, ...$friend->getFiles());
        array_push($this->packages, ...$friend->getPackages());

        return $this;
    }
}
