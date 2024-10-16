<?php

namespace MuseFx\PhpMusicXml\Elements;

use MuseFx\PhpMusicXml\MusicXml;

class TimeModification extends Element
{
    /**
     * @var CustomElement
     */
    protected CustomElement $actualNotes;

    /**
     * @var CustomElement
     */
    protected CustomElement $normalNotes;

    /**
     * @var CustomElement
     */
    protected CustomElement $normalType;

    /**
     * @param MusicXml $document
     * @param int $actual
     * @param int $normal
     * @param string $type
     */
    public function __construct(
        MusicXml $document,
        int $actual = 3,
        int $normal = 2,
        string $type = Beat::TYPE_EIGHTH
    ) {
        parent::__construct($document);

        $this->actualNotes = new CustomElement($this->document, 'actual-notes');
        $this->normalNotes = new CustomElement($this->document, 'normal-notes');
        $this->normalType = new CustomElement($this->document, 'normal-type');

        $this->actualNotes->setValue($actual);
        $this->normalNotes->setValue($normal);
        $this->normalType->setValue($type);

        $this->addElement($this->actualNotes);
        $this->addElement($this->normalNotes);
        $this->addElement($this->normalType);
    }

    /**
     * @param int $actual
     *
     * @return self
     */
    public function setActualNotes(int $actual): self
    {
        $this->actualNotes->setValue($actual);

        return $this;
    }

    /**
     * @return int
     */
    public function getActualNotes(): int
    {
        return (int) $this->actualNotes->getValue();
    }

    /**
     * @param int $normal
     *
     * @return self
     */
    public function setNormalNotes(int $normal): self
    {
        $this->normalNotes->setValue($normal);

        return $this;
    }

    /**
     * @return int
     */
    public function getNormalNotes(): int
    {
        return (int) $this->normalNotes->getValue();
    }

    /**
     * @param string $type
     *
     * @return self
     */
    public function setNormalType(string $type): self
    {
        $this->normalType->setValue($type);

        return $this;
    }

    /**
     * @return string
     */
    public function getNormalType(): string
    {
        return $this->normalType->getValue();
    }
}
