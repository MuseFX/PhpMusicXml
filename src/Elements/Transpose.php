<?php

namespace MuseFx\PhpMusicXml\Elements;

use MuseFx\PhpMusicXml\MusicXml;

class Transpose extends Element
{
    /**
     * @var CustomElement
     */
    protected CustomElement $diatonic;

    /**
     * @var CustomElement
     */
    protected CustomElement $chromatic;

    /**
     * @param MusicXml $document
     */
    public function __construct(MusicXml $document)
    {
        parent::__construct($document);

        $this->diatonic = new CustomElement($this->document, 'diatonic');
        $this->chromatic = new CustomElement($this->document, 'chromatic');

        $this->addElement($this->diatonic)->addElement($this->chromatic);
    }

    /**
     * @param int $chromatic
     * @param int|null $diatonic
     *
     * @return self
     */
    public function transpose(int $chromatic, ?int $diatonic = null): self
    {
        if (is_null($diatonic)) {
            $round = $chromatic < 0 ? 'floor' : 'ceil';
            $diatonic = $round($chromatic / 2);
        }

        $this->diatonic->setValue($diatonic);
        $this->chromatic->setValue($chromatic);

        return $this;
    }
}
