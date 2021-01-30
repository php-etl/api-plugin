<?php declare(strict_types=1);

namespace Kiboko\Plugin\API\Builder;

use Jane\Component\JsonSchema\Registry\Registry;
use PhpParser\Builder;
use PhpParser\Node;

final class OpenAPI implements Builder
{
    private ?string $namespace;
    private ?string $endpoint;

    public function __construct(private Registry $jane)
    {
        $this->namespace = null;
        $this->endpoint = null;
    }

    public function withNamespace(string $namespace): self
    {
        $this->namespace = $namespace;

        return $this;
    }

    public function withEndpoint(string $endpoint): self
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    public function getNode(): Node
    {
        return new Node\Expr\New_(
            new Node\Stmt\Class_(
                name: null,
                subNodes: [
                    'stmts' => [
                        new Node\Stmt\ClassMethod(
                            name: new Node\Identifier('__construct'),
                            subNodes: [
                                'flags' => Node\Stmt\Class_::MODIFIER_PUBLIC,
                                'params' => [
                                    new Node\Param(
                                        var: new Node\Expr\Variable('client'),
                                        type: new Node\Name\FullyQualified($this->namespace . '\\Client'),
                                        flags: Node\Stmt\Class_::MODIFIER_PRIVATE,
                                    ),
                                ],
                            ],
                        ),
                        new Node\Stmt\ClassMethod(
                            name: new Node\Identifier('extract'),
                            subNodes: [
                                'flags' => Node\Stmt\Class_::MODIFIER_PUBLIC,
                                'returnType' => new Node\Identifier('iterable'),
                                'stmts' => [
                                    new Node\Stmt\Expression(
                                        expr: new Node\Expr\YieldFrom(
                                            expr: new Node\Expr\MethodCall(
                                                var: new Node\Expr\PropertyFetch(
                                                    var: new Node\Expr\Variable('this'),
                                                    name: new Node\Identifier('client'),
                                                ),
                                                name: new Node\Identifier($this->endpoint),
                                            ),
                                        ),
                                    ),
                                ],
                            ],
                        ),
                    ],
                    'implements' => [
                        new Node\Name\FullyQualified('Kiboko\\Contracts\\Pipeline\\ExtractorInterface'),
                    ]
                ],
            ),
        );
    }
}
