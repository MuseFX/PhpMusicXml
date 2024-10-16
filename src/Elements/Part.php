<?php

namespace MuseFx\PhpMusicXml\Elements;

use MuseFx\PhpMusicXml\MusicXml;

class Part extends Element
{
    protected string $id;

    protected ScorePart $scorePart;

    /**
     * @var array<\MuseFx\PhpMusicXml\Elements\Measure>
     */
    protected array $measures = [];

    /**
     * @param MusicXml $document
     * @param ScorePart $scorePart
     */
    public function __construct(MusicXml $document, ScorePart $scorePart)
    {
        parent::__construct($document);

        $this->scorePart = $scorePart;

        $this->id = $this->scorePart->getId();
        $this->setAttribute('id', $this->id);
    }

    /**
     * @return Measure
     */
    public function createMeasure(): Measure
    {
        $number = max(array_keys($this->measures) ?: [0]) + 1;
        $measure = new Measure($this->document, $this, $number);

        if (empty($this->measures)) {
            $measure->clef(
                function (Clef $clef) {
                    if ($this->isDrumkit()) {
                        $clef->setPercussion();
                    } else {
                        $clef->setViolin();
                    }
                }
            )->time()->key();
        }

        $this->measures[$number] = $measure;
        $this->addElement($measure);

        return $measure;
    }

    /**
     * @return array<\MuseFx\PhpMusicXml\Elements\Measure>
     */
    public function getMeasures(): array
    {
        return $this->measures;
    }

    /**
     * @return bool
     */
    public function isDrumkit(): bool
    {
        return $this->scorePart->isDrumkit();
    }

    /**
     * @return string|null
     */
    public function getDrumkitPrefix(): ?string
    {
        return $this->scorePart->getDrumkitPrefix();
    }
}
