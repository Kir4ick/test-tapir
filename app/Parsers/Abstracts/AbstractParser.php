<?php

namespace App\Parsers\Abstracts;

abstract class AbstractParser implements IParserContract
{

    public function parse(string $content): array
    {
        if (!json_validate($content)) {
            $content = str_replace('<?xml version="1.0" encoding="UTF-8"?>', '', $content);
            $xml = simplexml_load_string($content);
            $namespaces = $xml->getDocNamespaces();

            foreach ($namespaces as $prefix => $url) {
                $content = preg_replace(sprintf('/%s:/', $prefix), '', $content);
                $url = preg_replace('~/~', '\/', $url);
                $content = preg_replace(sprintf('/[a-z]+:%s="%s"/', $prefix, $url), '', $content);
            }

            $content = json_encode(simplexml_load_string($content), JSON_UNESCAPED_UNICODE);
        }

        return $this->mapArray(json_decode($content, true));

    }

    abstract protected function mapArray(array $array): array;
}
