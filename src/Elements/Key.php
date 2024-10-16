<?php

namespace MuseFx\PhpMusicXml\Elements;

use MuseFx\PhpMusicXml\MusicXml;

class Key extends Element
{
    /**
     * @var CustomElement
     */
    protected CustomElement $fifths;

    /**
     * @param MusicXml $document
     * @param int $fifths
     */
    public function __construct(MusicXml $document, int $fifths = 0)
    {
        parent::__construct($document);

        $this->fifths = new CustomElement($this->document, 'fifths');
        $this->fifths->setValue($fifths);
        $this->addElement($this->fifths);
    }

    /**
     * @param int $fifths
     *
     * @return self
     */
    public function setFifths(int $fifths): self
    {
        $this->fifths->setValue($fifths);

        return $this;
    }

    /**
     * @return int
     */
    public function getFifths(): int
    {
        return (int) $this->fifths->getValue();
    }
}
