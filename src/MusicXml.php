<?php

namespace MuseFx\PhpMusicXml;

use MuseFx\PhpMusicXml\Elements\ScorePartwise;
use DOMDocument;
use DOMImplementation;

class MusicXml
{
    public const OUTPUT_FORMATTED = 0b1;
    public const STRICT_MEASURES = 0b10;

    /**
     * @var DOMDocument
     */
    protected DOMDocument $document;

    /**
     * @var ScorePartwise
     */
    protected ScorePartwise $score;

    public function __construct()
    {
        $this->document = new DOMDocument('1.0', 'UTF-8');
        $this->document->xmlStandalone = false;

        $implementation = new DOMImplementation;
        $doctype = $implementation->createDocumentType(
            'score-partwise',
            '-//Recordare//DTD MusicXML 4.0 Partwise//EN',
            'http://www.musicxml.org/dtds/partwise.dtd'
        );
        $this->document->appendChild($doctype);
    }

    /**
     * @param  $version
     *
     * @return ScorePartwise
     */
    public function createScore($version = ScorePartwise::DEFAULT_VERSION): ScorePartwise
    {
        $this->score = new ScorePartwise($this);
        $this->score->setVersion($version);
        $this->document->appendChild($this->score->getElement());

        return $this->score;
    }

    /**
     * @param int $options
     *
     * @return string
     */
    public function getContent(int $options = 0): string
    {
        $checkMeasures = false;
        if ($options & self::OUTPUT_FORMATTED) {
            $this->document->formatOutput = true;
        }
        if ($options & self::STRICT_MEASURES) {
            $checkMeasures = true;
        }
        return $this->fine($checkMeasures)->document->saveXML();
    }

    /**
     * @return DOMDocument
     */
    public function getDocument(): DOMDocument
    {
        return $this->document;
    }

    /**
     * @param bool $checkMeasures
     *
     * @return self
     */
    public function fine(bool $checkMeasures): self
    {
        foreach ($this->score->getPartList()->getParts() as $part) {
            foreach ($part->getPart()->getMeasures() as $measure) {
                $measure->addNotes($checkMeasures);
            }
        }

        return $this;
    }
}
