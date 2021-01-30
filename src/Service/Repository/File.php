<?php declare(strict_types=1);

namespace Kiboko\Plugin\API\Service\Repository;

use Kiboko\Contract\Configurator\FileInterface;
use PhpParser\Node;

final class File implements FileInterface
{
    public function __construct(private string $pathname, private Node $node)
    {}

    public function getPathname(): string
    {
        return $this->pathname;
    }

    public function getNode(): Node
    {
        return $this->node;
    }
}
