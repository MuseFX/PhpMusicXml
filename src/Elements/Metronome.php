<?php

namespace MuseFx\PhpMusicXml\Elements;

use MuseFx\PhpMusicXml\MusicXml;

class Metronome extends Element
{
    protected CustomElement $beatUnit;
    protected CustomElement $perMinute;

    /**
     * @param MusicXml $document
     * @param int $bpm
     * @param string $type
     */
    public function __construct(MusicXml $document, int $bpm = 120, string $type = Beat::TYPE_QUARTER)
    {
        parent::__construct($document);

        $this->beatUnit = new CustomElement($this->document, 'beat-unit');
        $this->perMinute = new CustomElement($this->document, 'per-minute');

        $this->setBeatUnit($type)->setBpm($bpm)
            ->addElement($this->beatUnit)
            ->addElement($this->perMinute);
    }

    /**
     * @param string $type
     *
     * @return self
     */
    public function setBeatUnit(string $type): self
    {
        $this->beatUnit->setValue($type);

        return $this;
    }

    /**
     * @param int $bpm
     *
     * @return self
     */
    public function setBpm(int $bpm): self
    {
        $this->perMinute->setValue($bpm);

        return $this;
    }

    /**
     * @return string
     */
    public function getBeatUnit(): string
    {
        return (string) $this->getValue();
    }

    /**
     * @return int
     */
    public function getBpm(): int
    {
        return (int) $this->getValue();
    }
}
