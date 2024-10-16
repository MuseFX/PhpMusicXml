<?php

namespace MuseFx\PhpMusicXml\Helpers;

use MuseFx\PhpMusicXml\Contracts\NoteContainer;
use MuseFx\PhpMusicXml\Elements\Beat;
use MuseFx\PhpMusicXml\Elements\CustomElement;
use MuseFx\PhpMusicXml\Elements\DrumBeat;
use MuseFx\PhpMusicXml\Elements\Measure;
use MuseFx\PhpMusicXml\Elements\Note;
use MuseFx\PhpMusicXml\Elements\Rest;
use MuseFx\PhpMusicXml\MusicXml;
use Closure;

class Tuplet implements NoteContainer
{
    /**
     * @var Measure
     */
    protected Measure $measure;

    /**
     * @var MusicXml
     */
    protected MusicXml $document;

    /**
     * @var NoteCalculator
     */
    protected NoteCalculator $calculator;

    /**
     * @var int
     */
    protected int $into;

    /**
     * @var int
     */
    protected int $from;

    /**
     * @var array<\MuseFx\PhpMusicXml\Elements\Beat>
     */
    protected array $notes = [];

    /**
     * @param Measure $measure
     * @param int $into
     * @param int $from
     */
    public function __construct(Measure $measure, int $into, int $from)
    {
        $this->measure = $measure;
        $this->document = $this->measure->getDocument();
        $this->into = $into;
        $this->from = $from;
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
        $this->notes[] = $this->tupletize($note);

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
        $this->notes[] = $this->tupletize($note);

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
        $this->notes[] = $this->tupletize($rootNote);

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
        $drumBeat = new DrumBeat($this->document, $instrument, $type, $this->measure->getDrumkitPrefix());
        $this->notes[] = $drumBeat;

        return $drumBeat;
    }

    /**
     * @return array<\MuseFx\PhpMusicXml\Elements\Beat>
     */
    public function getNotes(): array
    {
        return $this->notes;
    }

    /**
     * @param Beat $note
     *
     * @return Beat
     */
    protected function tupletize(Beat $note): Beat
    {
        if ($note instanceof Note && $note->getChord()) {
            foreach ($note->getChord()->getNotes() as $thisNote) {
                $thisNote->setTimeModification($this->into, $this->from);
            }

            return $note;
        }
        return $note->setTimeModification($this->into, $this->from);
    }

    /**
     * @return self
     */
    public function displayTuplet(): self
    {
        $first = current($this->notes);
        $last = end($this->notes);

        $tupletActual = new CustomElement($this->document, 'tuplet-actual');
        $tupletNormal = new CustomElement($this->document, 'tuplet-normal');

        if (!empty($first)) {
            $first->addNotation(
                'tuplet',
                ['type' => 'start', 'bracket' => 'yes'],
                function (CustomElement $notation) use ($tupletActual, $tupletNormal) {
                    $notation->addElement($tupletActual)->addElement($tupletNormal);
                }
            );
        }

        if (!empty($last)) {
            $last->addNotation(
                'tuplet',
                ['type' => 'stop'],
                function (CustomElement $notation) use ($tupletActual, $tupletNormal) {
                    $notation->addElement($tupletActual)->addElement($tupletNormal);
                }
            );
        }

        return $this;
    }
}
