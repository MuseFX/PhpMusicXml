<?php

namespace MuseFx\PhpMusicXml\Midi;

use MuseFx\PhpMusicXml\Elements\MidiInstrument;
use MuseFx\PhpMusicXml\Elements\ScoreInstrument;
use MuseFx\PhpMusicXml\Elements\ScorePart;

class Instrument
{
    /**
     * @var int
     */
    protected int $midiReference;

    /**
     * @var string
     */
    protected string $label;

    /**
     * @var ScoreInstrument
     */
    protected ScoreInstrument $scoreInstrument;

    /**
     * @var MidiInstrument
     */
    protected MidiInstrument $midiInstrument;

    /**
     * @param int $midiReference
     */
    public function __construct(int $midiReference)
    {
        $this->midiReference = $midiReference;
        $this->label = Instruments::getInstrumentLabel($this->midiReference);
    }

    /**
     * @param ScorePart $part
     * @param string $id
     *
     * @return self
     */
    public function bindToPart(ScorePart $part, string $id): self
    {
        $this->scoreInstrument = new ScoreInstrument($part->getDocument());
        $this->midiInstrument = new MidiInstrument($part->getDocument(), $this->midiReference);
        $this->scoreInstrument->getElement()->setAttribute('id', $id);
        $this->midiInstrument->getElement()->setAttribute('id', $id);

        $this->scoreInstrument->setName($this->label);

        $part->addElement($this->scoreInstrument);
        $part->addElement($this->midiInstrument);

        return $this;
    }

    /**
     * @return MidiInstrument
     */
    public function getMidiInstrument(): MidiInstrument
    {
        return $this->midiInstrument;
    }

    /**
     * @return ScoreInstrument
     */
    public function getScoreInstrument(): ScoreInstrument
    {
        return $this->scoreInstrument;
    }
}
