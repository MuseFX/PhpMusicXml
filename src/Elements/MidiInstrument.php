<?php

namespace MuseFx\PhpMusicXml\Elements;

use MuseFx\PhpMusicXml\MusicXml;

class MidiInstrument extends Element
{
    public const DEFAULT_CHANNEL = 1;
    public const DEFAULT_VOLUME = 80;
    public const DEFAULT_PAN = 0;
    public const PERCUSSION_CHANNEL = 10;

    protected CustomElement $channel;
    protected CustomElement $program;
    protected CustomElement $volume;
    protected CustomElement $pan;

    /**
     * @param MusicXml $document
     * @param int $program
     * @param int $channel
     */
    public function __construct(MusicXml $document, int $program, int $channel = self::DEFAULT_CHANNEL)
    {
        parent::__construct($document);

        $this->channel = new CustomElement($this->document, 'midi-channel');
        $this->program = new CustomElement($this->document, 'midi-program');
        $this->volume = new CustomElement($this->document, 'volume');
        $this->pan = new CustomElement($this->document, 'pan');

        $this->channel->setValue($channel);
        $this->program->setValue($program);
        $this->volume->setValue(self::DEFAULT_VOLUME);
        $this->pan->setValue(self::DEFAULT_PAN);

        $this->addElement($this->channel);
        $this->addElement($this->program);
        $this->addElement($this->volume);
        $this->addElement($this->pan);
    }

    /**
     * @param int $volume
     *
     * @return self
     */
    public function setVolume(int $volume): self
    {
        $this->volume->setValue($volume);

        return $this;
    }

    /**
     * @return int
     */
    public function getVolume(): int
    {
        return $this->volume->getValue();
    }

    /**
     * @param int $pan
     *
     * @return self
     */
    public function setPan(int $pan): self
    {
        $this->pan->setValue($pan);

        return $this;
    }

    /**
     * @return int
     */
    public function getPan(): int
    {
        return $this->pan->getValue();
    }

    /**
     * @param int $channel
     *
     * @return self
     */
    public function setChannel(int $channel): self
    {
        $this->channel->setValue($channel);

        return $this;
    }

    /**
     * @return int
     */
    public function getChannel(): int
    {
        return $this->channel->getValue();
    }
}
