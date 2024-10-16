<?php

namespace MuseFx\PhpMusicXml\Contracts;

use MuseFx\PhpMusicXml\Elements\Beat;
use MuseFx\PhpMusicXml\Elements\DrumBeat;
use MuseFx\PhpMusicXml\Elements\Note;
use MuseFx\PhpMusicXml\Elements\Rest;
use MuseFx\PhpMusicXml\Helpers\Chord;
use Closure;

interface NoteContainer
{
    /**
     * addNote
     *
     * @param  mixed $note
     * @param  mixed $octave
     * @param  mixed $type
     * @return Note
     */
    public function addNote(string $note = 'C', int $octave = 4, string $type = Beat::TYPE_QUARTER): Note;

    /**
     * addRest
     *
     * @param  mixed $type
     * @return Rest
     */
    public function addRest(string $type = Beat::TYPE_QUARTER): Rest;

    /**
     * addDrumBeat
     *
     * @param  mixed $instrument
     * @param  mixed $type
     * @return DrumBeat
     */
    public function addDrumBeat(int $instrument, string $type = Beat::TYPE_QUARTER): DrumBeat;

    /**
     * addChord
     *
     * @param  mixed $callback
     * @return Chord
     */
    public function addChord(Closure $callback): Chord;

    /**
     * getNotes
     *
     * @return array
     */
    public function getNotes(): array;

}
