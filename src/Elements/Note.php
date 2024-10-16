<?php

namespace MuseFx\PhpMusicXml\Elements;

use MuseFx\PhpMusicXml\Exceptions\Exception as MusicXmlException;
use MuseFx\PhpMusicXml\Helpers\Chord;
use MuseFx\PhpMusicXml\Helpers\NoteCalculator;
use MuseFx\PhpMusicXml\MusicXml;

class Note extends Beat
{
    /**
     * @var Pitch
     */
    protected Pitch $pitch;

    /**
     * @var CustomElement
     */
    protected CustomElement $alter;

    /**
     * @var Chord|null|null
     */
    protected ?Chord $chord = null;

    /**
     * @param MusicXml $document
     * @param string $note
     * @param int $octave
     * @param string $type
     */
    public function __construct(
        MusicXml $document,
        string $note = 'C',
        int $octave = 4,
        string $type = self::TYPE_QUARTER
    ) {
        parent::__construct($document, $type);

        $this->pitch = new Pitch($this->document, $note, $octave);
        $this->addElement($this->pitch);
    }

    /**
     * @return self
     */
    public function sharp(): self
    {
        $this->pitch->alter(1);

        return $this;
    }

    /**
     * @return self
     */
    public function flat(): self
    {
        $this->pitch->alter(-1);

        return $this;
    }

    /**
     * @return self
     */
    public function doubleSharp(): self
    {
        $this->pitch->alter(2);

        return $this;
    }

    /**
     * @return self
     */
    public function flatFlat(): self
    {
        $this->pitch->alter(-2);

        return $this;
    }

    /**
     * @param string $note
     *
     * @return self
     */
    public function setNote(string $note): self
    {
        $this->pitch->setStep($note);

        return $this;
    }

    /**
     * @param int $octave
     *
     * @return self
     */
    public function setOctave(int $octave): self
    {
        $this->pitch->setOctave($octave);

        return $this;
    }

    /**
     * @return Pitch
     */
    public function getPitch()
    {
        return $this->pitch;
    }

    /**
     * @param Chord $chord
     *
     * @return self
     */
    public function setChord(Chord $chord): self
    {
        $this->chord = $chord;

        return $this;
    }

    /**
     * @return Chord|null
     */
    public function getChord(): ?Chord
    {
        return $this->chord;
    }

    /**
     * @param NoteCalculator $noteCalculator
     *
     * @return float
     */
    public function setDuration(NoteCalculator $noteCalculator)
    {
        $return = parent::setDuration($noteCalculator);

        if (!empty($this->chord)) {
            $this->chord->setDurations();
        }

        return $return;
    }

    /**
     * @param Measure $measure
     *
     * @return self
     */
    public function addToMeasure(Measure $measure): self
    {
        if (!empty($this->chord)) {
            $notes = $this->chord->getNotes();
            foreach ($notes as $note) {
                $measure->addElement($note);
            }

            return $this;
        }

        return parent::addToMeasure($measure);
    }
}
