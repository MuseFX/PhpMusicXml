<?php

namespace MuseFx\PhpMusicXml\Elements;

use MuseFx\PhpMusicXml\MusicXml;

class Clef extends Element
{
    public const VIOLIN = 'G';
    public const VIOLA = 'C';
    public const BASS = 'F';
    public const PERCUSSION = 'percussion';

    /**
     * @var CustomElement
     */
    protected CustomElement $sign;

    /**
     * @var CustomElement
     */
    protected CustomElement $line;

    /**
     * @param MusicXml $document
     */
    public function __construct(MusicXml $document)
    {
        parent::__construct($document);

        $this->sign = new CustomElement($this->document, 'sign');
        $this->line = new CustomElement($this->document, 'line');

        $this->addElement($this->sign)->addElement($this->line);

        $this->setViolin();
    }

    /**
     * @param string $sign
     *
     * @return self
     */
    public function setSign(string $sign): self
    {
        $this->sign->setValue($sign);

        return $this;
    }

    /**
     * @return string
     */
    public function getSign(): string
    {
        return $this->sign->getValue();
    }

    /**
     * @param string $line
     *
     * @return self
     */
    public function setLine(string $line): self
    {
        $this->line->setValue($line);

        return $this;
    }

    /**
     * @return string
     */
    public function getLine(): string
    {
        return $this->line->getValue();
    }

    /**
     * @return self
     */
    public function setViolin(): self
    {
        return $this->setSign(self::VIOLIN)->setLine('2');
    }

    /**
     * @return self
     */
    public function setViola(): self
    {
        return $this->setSign(self::VIOLA)->setLine('3');
    }

    /**
     * @return self
     */
    public function setBass(): self
    {
        return $this->setSign(self::BASS)->setLine('4');
    }

    /**
     * @return self
     */
    public function setPercussion(): self
    {
        return $this->setSign(self::PERCUSSION)->setLine('2');
    }
}
