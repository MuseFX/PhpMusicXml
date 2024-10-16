<?php

namespace MuseFx\PhpMusicXml\Helpers;

use MuseFx\PhpMusicXml\Contracts\NoteContainer;
use MuseFx\PhpMusicXml\Elements\Beat;
use MuseFx\PhpMusicXml\Elements\CustomElement;
use MuseFx\PhpMusicXml\Elements\Note;
use MuseFx\PhpMusicXml\Elements\Rest;
use MuseFx\PhpMusicXml\Exceptions\Exception as MusicXmlException;
use MuseFx\PhpMusicXml\MusicXml;

class Chord
{
    /**
     * @var MusicXml
     */
    protected MusicXml $document;

    /**
     * @var Note
     */
    protected Note $root;

    /**
     * @param MusicXml $document
     */
    public function __construct(MusicXml $document)
    {
        $this->document = $document;
    }

    /**
     * @var array<\MuseFx\PhpMusicXml\Elements\Beat>
     */
    protected array $notes = [];

    /**
     * @param string $note
     * @param int $octave
     * @param string $type
     *
     * @return Note
     */
    public function addRoot(string $note = 'C', int $octave = 4, string $type = Beat::TYPE_QUARTER): Note
    {
        if (!empty($this->root)) {
            throw new MusicXmlException('The root note already specified.');
        }
        $note = $this->createNote($note, $octave, $type);
        $this->root = $note;

        return $note;
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
        return $this->createNote($note, $octave, $type)->addElement(
            new CustomElement($this->document, 'chord')
        );
    }

    /**
     * @return Note|null
     */
    public function getRootNote(): ?Note
    {
        return $this->root;
    }

    /**
     * @var array<\MuseFx\PhpMusicXml\Elements\Beat>
     */
    /**
     * @return array
     */
    public function getNotes(): array
    {
        return $this->notes;
    }

    /**
     * @param string $note
     * @param int $octave
     * @param string $type
     *
     * @return Note
     */
    protected function createNote(string $note = 'C', int $octave = 4, string $type = Beat::TYPE_QUARTER): Note
    {
        $note = new Note($this->document, $note, $octave, $type);
        $this->notes[] = $note;

        return $note;
    }

    /**
     * @return self
     */
    public function setDurations(): self
    {
        $duration = (int) $this->root->getDurationElement()->getValue();

        foreach ($this->notes as $note) {
            $note->getDurationElement()->setValue($duration);
        }

        return $this;
    }
}
