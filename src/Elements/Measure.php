<?php

namespace MuseFx\PhpMusicXml\Elements;

use MuseFx\PhpMusicXml\Contracts\NoteContainer;
use MuseFx\PhpMusicXml\Exceptions\Exception as MusicXmlException;
use MuseFx\PhpMusicXml\Helpers\Chord;
use MuseFx\PhpMusicXml\Helpers\NoteCalculator;
use MuseFx\PhpMusicXml\Helpers\Stafe;
use MuseFx\PhpMusicXml\Helpers\Tuplet;
use MuseFx\PhpMusicXml\MusicXml;
use Closure;

class Measure extends Element implements NoteContainer
{
    /**
     * @var int
     */
    protected int $number;

    /**
     * @var CustomElement|null
     */
    protected ?CustomElement $attributes;

    /**
     * @var CustomElement|null
     */
    protected ?CustomElement $divisions;

    /**
     * @var CustomElement|null
     */
    protected ?CustomElement $stavesCount;

    /**
     * @var Key|null
     */
    protected ?Key $key;

    /**
     * @var Time|null
     */
    protected ?Time $time;

    /**
     * @var Clef|null
     */
    protected ?Clef $clef;

    /**
     * @var Transpose|null
     */
    protected ?Transpose $transpose;

    /**
     * @var Part
     */
    protected Part $part;

    /**
     * @var Measure|null|null
     */
    protected ?Measure $parent = null;

    /**
     * @var array<\MuseFx\PhpMusicXml\Elements\Beat>
     */
    protected array $notes = [];

    /**
     * @var array<\MuseFx\PhpMusicXml\Elements\Beat>
     */
    protected array $directions = [];

    protected NoteCalculator $calculator;

    /**
     * @var array<\MuseFx\PhpMusicXml\Helpers\Stafe>
     */
    protected array $staves = [];

    /**
     * @param MusicXml $document
     * @param Part $part
     * @param int $number
     */
    public function __construct(MusicXml $document, Part $part, int $number)
    {
        parent::__construct($document);

        $this->part = $part;
        $this->number = $number;

        $partMeasures = $this->part->getMeasures();
        $this->parent = end($partMeasures) ?: null;

        $this->getElement()->setAttribute('number', $this->number);

        $this->calculator = new NoteCalculator($this);
    }

    /**
     * @param Closure|null $set
     *
     * @return self
     */
    public function key(?Closure $set = null): self
    {
        // Create default key
        if (empty($this->key)) {
            $this->key = new Key($this->document);
            $this->addAttribute($this->key);
        }

        if (is_callable($set)) {
            $set($this->key);
        }

        return $this;
    }

    /**
     * @param Closure|null $set
     *
     * @return self
     */
    public function time(?Closure $set = null): self
    {
        // Create default time
        if (empty($this->time)) {
            $this->time = new Time($this->document);
            $this->addAttribute($this->time);
        }

        if (is_callable($set)) {
            $set($this->time);
        }

        if (empty($this->divisions)) {
            $this->divisions = new CustomElement($this->document, 'divisions');
            $this->attributes->addElement($this->divisions);
        }
        $this->divisions->setValue($this->calculator->getDivision());

        return $this;
    }

    /**
     * @param Closure|null $set
     *
     * @return self
     */
    public function clef(?Closure $set = null): self
    {
        // Create default clef
        if (empty($this->clef)) {
            $this->clef = new Clef($this->document);
            $this->addAttribute($this->clef);
        }

        if (is_callable($set)) {
            $set($this->clef);
        }

        return $this;
    }

    /**
     * @param int $stafeNo
     * @param Closure|null $set
     *
     * @return self
     */
    public function stafe(int $stafeNo, ?Closure $set): self
    {
        if (empty($this->staves[$stafeNo])) {
            throw new MusicXmlException('Stafe `' . $stafeNo . '` not found.');
        }

        if (is_callable($set)) {
            $set($this->staves[$stafeNo]);
        }

        return $this;
    }

    /**
     * @return CustomElement
     */
    protected function createAttributes(): CustomElement
    {
        if (empty($this->attributes)) {
            $this->attributes = new CustomElement($this->document, 'attributes');
            $this->addElement($this->attributes);
        }

        if (!empty($this->clef) && empty($this->staves)) {
            // Default 1 stafe
            $this->stavesCount = new CustomElement($this->document, 'staves');
            $this->stavesCount->setValue(1);
            $this->attributes->addElement($this->stavesCount);

            $this->staves[1] = new Stafe($this->clef);
        }

        return $this->attributes;
    }

    /**
     * @param Element $attribute
     *
     * @return void
     */
    protected function addAttribute(Element $attribute): void
    {
        $this->createAttributes()->addElement($attribute);
    }

    /**
     * @param Closure|null $set
     *
     * @return self
     */
    public function addStafe(?Closure $set = null): self
    {
        $stafeNo = max(array_keys($this->staves) ?: [0]) + 1;
        $this->staves[$stafeNo] = new Stafe(new Clef($this->document));
        $this->stavesCount->setValue(count($this->staves));

        foreach ($this->staves as $thisStafeNo => $thisStafe) {
            $thisStafe->setNumber($thisStafeNo);
        }

        $this->attributes->addElement($this->staves[$stafeNo]->getClef());

        return $this->stafe($stafeNo, $set);
    }

    /**
     * @param string $note
     * @param int $octave
     * @param string $type
     *
     * @return Note
     */
    public function addNote(string $note = 'C', int $octave = 4, string $type = Beat::TYPE_QUARTER): Note
    {
        $note = new Note($this->document, $note, $octave, $type);
        // $this->addElement($note);
        $this->notes[] = $note;

        return $note;
    }

    /**
     * @param string $type
     *
     * @return Rest
     */
    public function addRest(string $type = Beat::TYPE_QUARTER): Rest
    {
        $note = new Rest($this->document, $type);
        $this->notes[] = $note;

        return $note;
    }

    /**
     * @param Closure $callback
     *
     * @return Chord
     */
    public function addChord(Closure $callback): Chord
    {
        $chord = new Chord($this->document);
        $callback($chord);

        $rootNote = $chord->getRootNote();
        if (empty($rootNote)) {
            throw new MusicXmlException('You need to specify a root note.');
        }

        $rootNote->setChord($chord);
        $this->notes[] = $rootNote;

        return $chord;
    }

    /**
     * @param int $instrument
     * @param string $type
     *
     * @return DrumBeat
     */
    public function addDrumBeat(int $instrument, string $type = Beat::TYPE_QUARTER): DrumBeat
    {
        $drumBeat = new DrumBeat($this->document, $instrument, $type, $this->part->getDrumkitPrefix());
        $this->notes[] = $drumBeat;

        return $drumBeat;
    }

    /**
     * @param int $into
     * @param int $from
     * @param Closure $callback
     *
     * @return Tuplet
     */
    public function addTuplet(int $into, int $from, Closure $callback): Tuplet
    {
        $tuplet = new Tuplet($this, $into, $from);

        $callback($tuplet);

        $tuplet->displayTuplet();

        foreach ($tuplet->getNotes() as $note) {
            $this->notes[] = $note;
        }

        return $tuplet;
    }

    /**
     * @return Direction
     */
    public function addDirection(): Direction
    {
        $direction = new Direction($this->document);
        $this->addElement($direction);
        $this->directions[] = $direction;

        return $direction;
    }

    /**
     * @return self
     */
    public function repeatForward(): self
    {
        $barline = new CustomElement($this->document, 'barline');
        $barline->setAttribute('location', 'left');

        $repeat = new CustomElement($this->document, 'repeat');
        $repeat->setAttribute('direction', 'forward');

        $barline->addElement($repeat);
        $this->addElement($barline);

        return $this;
    }

    /**
     * @param int|null $endingNumber
     *
     * @return self
     */
    public function repeatBackward(?int $endingNumber = null): self
    {
        $barline = new CustomElement($this->document, 'barline');
        $barline->setAttribute('location', 'right');

        if ($endingNumber) {
            $ending = new CustomElement($this->document, 'ending');
            $ending->setAttribute('number', $endingNumber);
            $ending->setAttribute('type', 'stop');
            $barline->addElement($ending);
        }

        $repeat = new CustomElement($this->document, 'repeat');
        $repeat->setAttribute('direction', 'backward');
        $barline->addElement($repeat);

        return $this->addElement($barline);
    }

    /**
     * @param int $endingNumber
     * @param string $type
     *
     * @return self
     */
    public function endingNumber(int $endingNumber, string $type = 'start'): self
    {
        $barline = new CustomElement($this->document, 'barline');
        $barline->setAttribute('location', 'left');

        $ending = new CustomElement($this->document, 'ending');
        $ending->setAttribute('number', $endingNumber);
        $ending->setAttribute('type', $type);
        if ($type == 'start') {
            $ending->setValue($endingNumber . '.');
        }
        $barline->addElement($ending);

        return $this->addElement($barline);
    }

    /**
     * @param int $chromatic
     * @param int|null $diatonic
     *
     * @return self
     */
    public function transpose(int $chromatic, ?int $diatonic = null): self
    {
        if (empty($this->transpose)) {
            $this->transpose = new Transpose($this->document);
            $this->addAttribute($this->transpose);
        }

        $this->transpose->transpose($chromatic, $diatonic);

        return $this;
    }

    /**
     * @return Measure|null
     */
    public function getParent(): ?Measure
    {
        return $this->parent;
    }

    /**
     * @return Key
     */
    public function getKey(): Key
    {
        return $this->key
            ?? $this->parent?->getKey()
            ?? new Key($this->document);
    }

    /**
     * @return Time
     */
    public function getTime(): Time
    {
        return $this->time
            ?? $this->parent?->getTime()
            ?? new Time($this->document);
    }

    /**
     * @return Transpose|null
     */
    public function getTranspose(): ?Transpose
    {
        return $this->transpose
            ?? $this->parent?->getTranspose()
            ?? null;
    }

    /**
     * @return array<\MuseFx\PhpMusicXml\Elements\Beat>
     */
    public function getNotes(): array
    {
        return $this->notes;
    }

    /**
     * @return NoteCalculator
     */
    public function getCalculator(): NoteCalculator
    {
        return $this->calculator;
    }

    /**
     * @var array<\MuseFx\PhpMusicXml\Helpers\Stafe>
     */
    public function getStaves(): array
    {
        if (!empty($this->staves)) {
            return $this->staves;
        }

        return $this->getParent()?->getStaves();
    }

    /**
     * @param bool $strictMeasures
     *
     * @return self
     */
    public function addNotes(bool $strictMeasures = true): self
    {
        $this->calculator->checkMeasureLength($strictMeasures);
        $staves = [];
        foreach ($this->getNotes() as $note) {
            $staves[$note->getStafe()][$note->getVoice()][] = $note;
        }

        foreach ($staves as $stafeNo => $voices) {
            foreach ($voices as $voiceNo => $notes) {
                foreach ($notes as $note) {
                    $note->addToMeasure($this);
                }
                $this->addBackupDuration();
            }
            $this->addBackupDuration();
        }

        return $this;
    }

    /**
     * @return void
     */
    protected function addBackupDuration(): void
    {
        $backup = new CustomElement($this->document, 'backup');
        $this->addElement($backup);
        $duration = new CustomElement($this->document, 'duration');
        $duration->setValue($this->calculator->getMeasureLength());
        $backup->addElement($duration);
    }

    /**
     * @return string|null
     */
    public function getDrumkitPrefix(): ?string
    {
        return $this->part->getDrumkitPrefix();
    }
}
