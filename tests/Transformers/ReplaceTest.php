<?php

/**
 * @author      Wizacha DevTeam <dev@wizacha.com>
 * @copyright   Copyright (c) Wizacha
 * @copyright   Copyright (c) Leonardo Marquine
 * @license     MIT
 */

declare(strict_types=1);

namespace Tests\Transformers;

use Tests\TestCase;
use Wizaplace\Etl\Row;
use Wizaplace\Etl\Transformers\Replace;

class ReplaceTest extends TestCase
{
    /**
     * Row array to be transformed in testing.
     *
     * @var Row[]
     */
    protected array $data;

    protected function setUp(): void
    {
        parent::setUp();

        $this->data = [
            new Row(['id' => '1', 'name' => 'John Doe', 'email' => 'johndoe@email.com']),
            new Row(['id' => '2', 'name' => 'Jane Doe', 'email' => 'janedoe@email.com']),
            new Row(['id' => '3', 'name' => 'Jane Doe', 'email' => 'janeDoe@email.com']),
        ];
    }

    /** @test */
    public function defaultTypeOption(): void
    {
        $expected = [
            new Row(['id' => '1', 'name' => 'John Die', 'email' => 'johndoe@email.com']),
            new Row(['id' => '2', 'name' => 'Jane Die', 'email' => 'janedoe@email.com']),
            new Row(['id' => '3', 'name' => 'Jane Die', 'email' => 'janeDie@email.com']),
        ];

        $transformer = new Replace();

        $transformer->options(
            [
                $transformer::SEARCH => 'Doe',
                $transformer::REPLACE => 'Die',
            ]
        );

        $this->execute($transformer, $this->data);

        static::assertEquals($expected, $this->data);
    }

    /** @test */
    public function defaultTypeOptionCustomColumns(): void
    {
        $expected = [
            new Row(['id' => '1', 'name' => 'John Die', 'email' => 'johndoe@email.com']),
            new Row(['id' => '2', 'name' => 'Jane Die', 'email' => 'janedoe@email.com']),
            new Row(['id' => '3', 'name' => 'Jane Die', 'email' => 'janeDoe@email.com']),
        ];

        $transformer = new Replace();

        $transformer->options(
            [
                $transformer::SEARCH => 'Doe',
                $transformer::REPLACE => 'Die',
                $transformer::COLUMNS => ['name'],
            ]
        );

        $this->execute($transformer, $this->data);

        static::assertEquals($expected, $this->data);
    }

    /** @test */
    public function strTypeOption(): void
    {
        $expected = [
            new Row(['id' => '1', 'name' => 'John Die', 'email' => 'johndoe@email.com']),
            new Row(['id' => '2', 'name' => 'Jane Die', 'email' => 'janedoe@email.com']),
            new Row(['id' => '3', 'name' => 'Jane Die', 'email' => 'janeDie@email.com']),
        ];

        $transformer = new Replace();

        $transformer->options(
            [
                $transformer::TYPE => 'str',
                $transformer::SEARCH => 'Doe',
                $transformer::REPLACE => 'Die',
            ]
        );

        $this->execute($transformer, $this->data);

        static::assertEquals($expected, $this->data);
    }

    /** @test */
    public function strTypeOptionCustomColumns(): void
    {
        $expected = [
            new Row(['id' => '1', 'name' => 'John Die', 'email' => 'johndoe@email.com']),
            new Row(['id' => '2', 'name' => 'Jane Die', 'email' => 'janedoe@email.com']),
            new Row(['id' => '3', 'name' => 'Jane Die', 'email' => 'janeDoe@email.com']),
        ];

        $transformer = new Replace();

        $transformer->options(
            [
                $transformer::TYPE => 'str',
                $transformer::SEARCH => 'Doe',
                $transformer::REPLACE => 'Die',
                $transformer::COLUMNS => ['name'],
            ]
        );

        $this->execute($transformer, $this->data);

        static::assertEquals($expected, $this->data);
    }

    /** @test */
    public function pregTypeOption(): void
    {
        $expected = [
            new Row(['id' => '1', 'name' => 'John Die', 'email' => 'johndoe@email.com']),
            new Row(['id' => '2', 'name' => 'Jane Die', 'email' => 'janedoe@email.com']),
            new Row(['id' => '3', 'name' => 'Jane Die', 'email' => 'janeDie@email.com']),
        ];

        $transformer = new Replace();

        $transformer->options(
            [
                $transformer::TYPE => 'preg',
                $transformer::SEARCH => '/Doe/m',
                $transformer::REPLACE => 'Die',
            ]
        );

        $this->execute($transformer, $this->data);

        static::assertEquals($expected, $this->data);
    }

    /** @test */
    public function pregTypeOptionCustomColumns(): void
    {
        $expected = [
            new Row(['id' => '1', 'name' => 'John Die', 'email' => 'johndoe@email.com']),
            new Row(['id' => '2', 'name' => 'Jane Die', 'email' => 'janedoe@email.com']),
            new Row(['id' => '3', 'name' => 'Jane Die', 'email' => 'janeDoe@email.com']),
        ];

        $transformer = new Replace();

        $transformer->options(
            [
                $transformer::TYPE => 'preg',
                $transformer::SEARCH => '/Doe/m',
                $transformer::REPLACE => 'Die',
                $transformer::COLUMNS => ['name'],
            ]
        );

        $this->execute($transformer, $this->data);

        static::assertEquals($expected, $this->data);
    }

    /** @test */
    public function throwsExceptionForUnsupportedReplaceType(): void
    {
        $transformer = new Replace();

        $transformer->options([$transformer::TYPE => 'invalid']);

        $this->expectException('InvalidArgumentException');

        $this->execute($transformer, $this->data);
    }
}
