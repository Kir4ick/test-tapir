<?php

namespace App\Parsers\Abstracts;

interface IParserContract
{
    public function parse(string $content): array;
}
