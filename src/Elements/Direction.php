<?php

namespace MuseFx\PhpMusicXml\Elements;

class Direction extends Element
{
    /**
     * @var Metronome
     */
    protected Metronome $metronome;

    /**
     * @var Dynamics
     */
    protected Dynamics $dynamics;

    /**
     * @param int $bpm
     * @param string $type
     *
     * @return self
     */
    public function setTempo(int $bpm = 120, string $type = Beat::TYPE_QUARTER): self
    {
        if (empty($this->metronome)) {
            $this->metronome = new Metronome($this->document, $bpm, $type);
            $this->addElement($this->metronome);
        } else {
            $this->metronome->setBpm($bpm)->setBeatUnit($type);
        }

        return $this;
    }

    /**
     * @return Dynamics
     */
    public function setDynamics(): Dynamics
    {
        $this->setAttribute('placement', 'below');
        if (empty($this->dynamics)) {
            $this->dynamics = new Dynamics($this->document);
            $this->addElement($this->dynamics);
        }

        return $this->dynamics;
    }

    /**
     * @return self
     */
    public function segno(): self
    {
        return $this->addElement(new CustomElement($this->document, 'segno'));
    }

    /**
     * @return self
     */
    public function coda(): self
    {
        return $this->addElement(new CustomElement($this->document, 'coda'));
    }

    /**
     * @param string $words
     *
     * @return self
     */
    public function words(string $words): self
    {
        $element = new CustomElement($this->document, 'words');
        $element->setValue($words);

        return $this->addElement($element);
    }

    /**
     * @param int $wedgeNumber
     *
     * @return self
     */
    public function startCrescendo(int $wedgeNumber = 1): self
    {
        return $this->addWedge('crescendo', $wedgeNumber);
    }

    /**
     * @param int $wedgeNumber
     *
     * @return self
     */
    public function startDiminuendo(int $wedgeNumber = 1): self
    {
        return $this->addWedge('diminuendo', $wedgeNumber);
    }

    /**
     * @param int $wedgeNumber
     *
     * @return [type]
     */
    public function stopCrescendo(int $wedgeNumber = 1) {
        return $this->stopWedge($wedgeNumber);
    }

    /**
     * @param int $wedgeNumber
     *
     * @return [type]
     */
    public function stopDiminuendo(int $wedgeNumber = 1) {
        return $this->stopWedge($wedgeNumber);
    }

    /**
     * @param int $wedgeNumber
     *
     * @return [type]
     */
    protected function stopWedge(int $wedgeNumber)
    {
        return $this->addWedge('stop', $wedgeNumber);
    }

    /**
     * @param string $wedgeType
     * @param int $wedgeNumber
     *
     * @return self
     */
    protected function addWedge(string $wedgeType, int $wedgeNumber): self
    {
        $this->setAttribute('placement', 'below');

        $wedge = new CustomElement($this->document, 'wedge');
        $wedge->setAttribute('type', $wedgeType);
        $wedge->setAttribute('number', $wedgeNumber);
        $this->addElement($wedge);

        return $this;
    }

    /**
     * @param Element $element
     *
     * @return Element
     */
    public function addElement(Element $element): Element
    {
        $directionType = new CustomElement($this->document, 'direction-type');
        $directionType->addElement($element);
        return parent::addElement($directionType);
    }
}
