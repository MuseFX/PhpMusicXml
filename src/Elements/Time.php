<?php

namespace MuseFx\PhpMusicXml\Elements;

use MuseFx\PhpMusicXml\Helpers\NoteCalculator;
use MuseFx\PhpMusicXml\MusicXml;

class Time extends Element
{
    /**
     * @var CustomElement
     */
    protected CustomElement $beats;

    /**
     * @var CustomElement
     */
    protected CustomElement $beatType;

    /**
     * @var bool
     */
    protected $useSymbols = false;

    /**
     * @param MusicXml $document
     * @param int $beats
     * @param int $beatType
     */
    public function __construct(MusicXml $document, int $beats = 4, int $beatType = 4)
    {
        parent::__construct($document);

        $this->beats = new CustomElement($document, 'beats');
        $this->beatType = new CustomElement($document, 'beat-type');

        $this->addElement($this->beats)->addElement($this->beatType);

        $this->setBeats($beats)->setBeatType($beatType);
    }

    /**
     * @param int $beats
     *
     * @return self
     */
    public function setBeats(int $beats): self
    {
        $this->beats->setValue($beats);
        $this->checkSymbols();

        return $this;
    }

    /**
     * @return int
     */
    public function getBeats(): int
    {
        return (int) $this->beats->getValue();
    }

    /**
     * @param int $beatType
     *
     * @return self
     */
    public function setBeatType(int $beatType): self
    {
        $this->beatType->setValue($beatType);
        $this->checkSymbols();

        return $this;
    }

    /**
     * @return int
     */
    public function getBeatType(): int
    {
        return (int) $this->beatType->getValue();
    }

    /**
     * @param bool $useSymbols
     *
     * @return self
     */
    public function useSymbols($useSymbols = true): self
    {
        $this->useSymbols = $useSymbols;
        $this->checkSymbols();

        return $this;
    }

    /**
     * @return self
     */
    protected function checkSymbols(): self
    {
        if ($this->useSymbols && $symbol = $this->getSymbol()) {
            $this->element->setAttribute('symbol', $symbol);
        } else {
            $this->element->removeAttribute('symbol');
        }

        return $this;
    }

    /**
     * @return string|null
     */
    protected function getSymbol(): ?string
    {
        $beatSymbols[4][4] = 'common';
        $beatSymbols[2][2] = 'cut';

        return $beatSymbols[$this->getBeats()][$this->getBeatType()] ?? null;
    }
}
