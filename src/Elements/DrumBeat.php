<?php

namespace MuseFx\PhpMusicXml\Elements;

use MuseFx\PhpMusicXml\Midi\Drumkit;
use MuseFx\PhpMusicXml\MusicXml;

class DrumBeat extends Beat
{
    /**
     * @var CustomElement
     */
    protected CustomElement $unpitched;

    /**
     * @var CustomElement
     */
    protected CustomElement $displayStep;

    /**
     * @var CustomElement
     */
    protected CustomElement $displayOctave;

    /**
     * @var CustomElement|null
     */
    protected ?CustomElement $notehead;

    protected ?string $elementName = 'note';

    /**
     * @param MusicXml $document
     * @param int $instrument
     * @param string $type
     * @param string $prefix
     */
    public function __construct(MusicXml $document, int $instrument, string $type = Beat::TYPE_QUARTER, string $prefix = '')
    {
        parent::__construct($document, $type);

        $this->unpitched = new CustomElement($this->document, 'unpitched');
        $this->displayStep = new CustomElement($this->document, 'display-step');
        $this->displayOctave = new CustomElement($this->document, 'display-octave');

        $instrumentProperties = Drumkit::getInstrument($instrument);

        $this->displayStep->setValue($instrumentProperties->displayStep);
        $this->displayOctave->setValue($instrumentProperties->displayOctave);

        $this->unpitched->addElement($this->displayStep)->addElement($this->displayOctave);
        $this->addElement($this->unpitched);

        if (!empty($instrumentProperties->notehead)) {
            $this->notehead = new CustomElement($this->document, 'notehead');
            $this->notehead->setValue($instrumentProperties->notehead);
            $this->addElement($this->notehead);
        }

        $instrumentId = $prefix . $instrumentProperties->id;

        $this->withInstrument($instrumentId);
    }
}
