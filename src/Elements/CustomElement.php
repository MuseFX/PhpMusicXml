<?php

namespace MuseFx\PhpMusicXml\Elements;

use MuseFx\PhpMusicXml\MusicXml;

class CustomElement extends Element
{
    /**
     * @param MusicXml $document
     * @param string $tagName
     */
    public function __construct(MusicXml $document, string $tagName)
    {
        $this->elementName = $tagName;
        parent::__construct($document);
    }
}
