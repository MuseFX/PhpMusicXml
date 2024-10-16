<?php

namespace MuseFx\PhpMusicXml\Elements;

use MuseFx\PhpMusicXml\MusicXml;

class Pitch extends Element
{
    /**
     * @var CustomElement
     */
    protected CustomElement $step;

    /**
     * @var CustomElement
     */
    protected CustomElement $alter;

    /**
     * @var CustomElement
     */
    protected CustomElement $octave;

    /**
     * @var array
     */
    protected array $allowedNotes = ['C', 'D', 'E', 'F', 'G', 'A', 'B'];

    /**
     * @var array
     */
    protected array $allowedAccidentals = [
        '#' => 1,
        'b' => -1,
        'bb' => -2,
        'x' => 2,
    ];

    /**
     * @param MusicXml $document
     * @param string $note
     * @param int $octave
     */
    public function __construct(MusicXml $document, string $note, int $octave)
    {
        parent::__construct($document);

        $this->step = new CustomElement($this->document, 'step');
        $this->alter = new CustomElement($this->document, 'alter');
        $this->octave = new CustomElement($this->document, 'octave');

        $this->setStep($note);
        $this->setOctave($octave);

        $this->addElement($this->step);
        $this->addElement($this->alter);
        $this->addElement($this->octave);
    }

    /**
     * @param int $alter
     *
     * @return self
     */
    public function alter(int $alter): self
    {
        $this->alter->setValue($alter);

        return $this;
    }

    /**
     * @return string
     */
    public function getStep(): string
    {
        return $this->step->getValue();
    }

    /**
     * @param string $note
     *
     * @return self
     */
    public function setStep(string $note): self
    {
        $setAlterNote = 0;
        foreach ($this->allowedAccidentals as $allowedAccidental => $alterNote) {
            if (strpos($note, $allowedAccidental) === 1) {
                $setAlterNote = $alterNote;
                $note = str_replace($allowedAccidental, '', $note);
                break;
            }
        }

        if (!in_array($note, $this->allowedNotes)) {
            throw new MusicXmlException('Not recognized note: `' . $note . '`.');
        }
        $this->step->setValue($note);
        $this->alter->setValue($setAlterNote);

        return $this;
    }

    /**
     * @return int
     */
    public function getOctave(): int
    {
        return (int) $this->octave->getValue();
    }

    /**
     * @param int $octave
     *
     * @return self
     */
    public function setOctave(int $octave): self
    {
        $this->octave->setValue($octave);

        return $this;
    }
}
