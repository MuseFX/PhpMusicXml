<?php

namespace MuseFx\PhpMusicXml\Elements;

use MuseFx\PhpMusicXml\MusicXml;

class Rest extends Beat
{
    /**
     * @var string|null
     */
    protected ?string $elementName = 'note';

    /**
     * @param MusicXml $document
     * @param string $type
     */
    public function __construct(MusicXml $document, string $type = self::TYPE_QUARTER)
    {
        parent::__construct($document, $type);

        $this->addElement(
            new CustomElement($this->document, 'rest')
        );
    }
}
