<?php

namespace MuseFx\PhpMusicXml;

use MuseFx\PhpMusicXml\Elements\ScorePartwise;
use DOMDocument;
use DOMElement;
use DOMImplementation;
use DOMNode;
use ReflectionClass;

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

    /**
     * @var string
     */
    protected string $serializedDocument;

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
     * @return ScorePartwise
     */
    public function getScore(): ScorePartwise
    {
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
        return $this->wakeupDocument()->document;
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

    /**
     * @return void
     */
    public function __sleep()
    {
        $this->fine(false);
        $mxmlId = 1;
        foreach ($this->document->getElementsByTagName('*') as $node) {
            if ($node instanceof DOMElement) {
                $node->setAttribute('mxml-id', $mxmlId++);
            }
        }

        $this->serializedDocument = $this->document->saveXML();

        $properties = [];
        $reflect = new ReflectionClass($this);
        foreach ($reflect->getProperties() as $property) {
            if ($property->isInitialized($this)) {
                $value = $property->getValue($this);
                if (!$value instanceof DOMDocument) {
                    $properties[] = $property->getName();
                }
            }
        }

        return $properties;
    }

    /**
     * @return void
     */
    public function __wakeup()
    {
        $this->wakeupDocument();
    }

    /**
     * @return self
     */
    protected function wakeupDocument(): self
    {
        if (empty($this->document)) {
            $this->document = new DOMDocument();
            $this->document->loadXML($this->serializedDocument);
        }

        return $this;
    }
}
