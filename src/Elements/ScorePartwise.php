<?php

namespace MuseFx\PhpMusicXml\Elements;

use MuseFx\PhpMusicXml\MusicXml;

class ScorePartwise extends Element
{
    public const DEFAULT_VERSION = '4.0';

    /**
     * @var PartList
     */
    public PartList $partList;

    /**
     * @var CustomElement|null
     */
    protected ?CustomElement $work;

    /**
     * @var CustomElement|null
     */
    protected ?CustomElement $identification;

    /**
     * @param MusicXml $document
     */
    public function __construct(MusicXml $document)
    {
        parent::__construct($document);

        $this->getElement()->setAttribute('version', self::DEFAULT_VERSION);
    }

    /**
     * @param string|null $id
     *
     * @return ScorePart
     */
    public function createScorePart(string $id = null): ScorePart
    {
        if (empty($this->partList)) {
            $this->partList = new PartList($this->document);
            $this->addElement($this->partList);
        }

        $scorePart = $this->partList->createScorePart($id);
        $part = $scorePart->createPart();
        $this->addElement($part);

        return $scorePart;
    }

    /**
     * @return PartList
     */
    public function getPartList(): PartList
    {
        return $this->partList;
    }

    /**
     * @param  $version
     *
     * @return self
     */
    public function setVersion($version = self::DEFAULT_VERSION): self
    {
        $this->getElement()->setAttribute('version', $version);

        return $this;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->getElement()->getAttribute('version');
    }

    /**
     * @param string $title
     *
     * @return self
     */
    public function setTitle(string $title): self
    {
        $titleElement = new CustomElement($this->document, 'work-title');
        $titleElement->setValue($title);

        $this->createWork()->addElement($titleElement);

        return $this;
    }

    /**
     * @param string $subtitle
     *
     * @return self
     */
    public function setSubtitle(string $subtitle): self
    {
        $subtitleElement = new CustomElement($this->document, 'work-subtitle');
        $subtitleElement->setValue($subtitle);

        $this->createWork()->addElement($subtitleElement);

        return $this;
    }

    /**
     * @param string $name
     * @param string $type
     *
     * @return self
     */
    public function addIdentification(string $name, string $type = 'composer'): self
    {
        $creator = new CustomElement($this->document, 'creator');
        $creator->setAttribute('type', $type);
        $creator->setValue($name);
        $this->createIdentification()->addElement($creator);

        return $this;
    }

    /**
     * @return CustomElement
     */
    protected function createWork(): CustomElement
    {
        if (empty($this->work)) {
            $this->work = new CustomElement($this->document, 'work');
            $this->addElement($this->work);
        }

        return $this->work;
    }

    /**
     * @return CustomElement
     */
    protected function createIdentification(): CustomElement
    {
        if (empty($this->identification)) {
            $this->identification = new CustomElement($this->document, 'identification');
            $this->addElement($this->identification);
        }

        return $this->identification;
    }
}
