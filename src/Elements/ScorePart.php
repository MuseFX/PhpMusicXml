<?php

namespace MuseFx\PhpMusicXml\Elements;

use MuseFx\PhpMusicXml\Midi\Drumkit;
use MuseFx\PhpMusicXml\Midi\Instrument;
use MuseFx\PhpMusicXml\MusicXml;

class ScorePart extends Element
{
    /**
     * @var string
     */
    protected string $id;

    /**
     * @var CustomElement
     */
    protected CustomElement $name;

    /**
     * @var CustomElement
     */
    protected CustomElement $group;

    /**
     * @var Part|null|null
     */
    protected ?Part $part = null;

    /**
     * @var bool
     */
    protected bool $isDrumkit = false;

    /**
     * @var string
     */
    protected string $drumkitPrefix;

    /**
     * @param MusicXml $document
     * @param string $id
     */
    public function __construct(MusicXml $document, string $id)
    {
        parent::__construct($document);

        $this->id = $id;
        $this->getElement()->setAttribute('id', $id);

        // Set the default name
        $this->name = new CustomElement($document, 'part-name');
        $this->name->getElement()->setAttribute('print-object', 'no'); // Set print no to default
        $this->name->setValue($id);
        $this->addElement($this->name);


        // Set the default group
        $this->group = new CustomElement($document, 'group');
        $this->group->setValue('score');
        $this->addElement($this->group);
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name->setValue($name);

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name->getValue();
    }

    /**
     * @param string $group
     *
     * @return self
     */
    public function setGroup(string $group): self
    {
        $this->group->setValue($group);

        return $this;
    }

    /**
     * @return string
     */
    public function getGroup(): string
    {
        return $this->group->getValue();
    }

    /**
     * @param bool $printName
     *
     * @return self
     */
    public function setPrintName(bool $printName = true): self
    {
        $this->name->getElement()->setAttribute('print-object', $printName ? 'yes' : 'no');

        return $this;
    }

    /**
     * @return bool
     */
    public function getPrintName(): bool
    {
       return $this->name->getElement()->getAttribute('print-object') == 'yes';
    }

    /**
     * @param Instrument $instrument
     * @param string|null $id
     *
     * @return Instrument
     */
    public function setInstrument(Instrument $instrument, string $id = null): Instrument
    {
        if (empty($id)) {
            $id = $this->id . '-INSTRUMENT';
        }
        return $instrument->bindToPart($this, $id);
    }

    /**
     * @param string $prefix
     *
     * @return self
     */
    public function setDrumkit(string $prefix = ''): self
    {
        $this->isDrumkit = true;
        $this->drumkitPrefix = $prefix;
        foreach (Drumkit::getInstruments() as $instrumentKey => $instrument)
        {
            $this->addDrumKitInstrument($instrument, $prefix);
        }

        return $this;
    }

    /**
     * @param object $drumkitInstrument
     * @param string $prefix
     *
     * @return self
     */
    protected function addDrumKitInstrument(object $drumkitInstrument, string $prefix)
    {
        $scoreInstrument = new ScoreInstrument($this->document);
        $midiInstrument = new MidiInstrument($this->document, 1, MidiInstrument::PERCUSSION_CHANNEL);
        $midiUnpitched = new CustomElement($this->document, 'midi-unpitched');
        $midiUnpitched->setValue($drumkitInstrument->midiId);
        $midiInstrument->addElement($midiUnpitched);
        $scoreInstrument->setName($drumkitInstrument->name);

        $id = $prefix . $drumkitInstrument->id;

        $scoreInstrument->setAttribute('id', $id);
        $midiInstrument->setAttribute('id', $id);

        $this->addElement($scoreInstrument);
        $this->addElement($midiInstrument);

        return $this;
    }

    /**
     * @return Part
     */
    public function createPart(): Part
    {
        $this->part = new Part($this->document, $this);

        return $this->part;
    }

    /**
     * @return Part
     */
    public function getPart(): Part
    {
        return $this->part;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getDrumkitPrefix(): ?string
    {
        return $this->drumkitPrefix;
    }

    /**
     * @return bool
     */
    public function isDrumkit(): bool
    {
        return $this->isDrumkit;
    }
}
