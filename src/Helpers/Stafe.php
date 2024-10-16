<?php

namespace MuseFx\PhpMusicXml\Helpers;

use MuseFx\PhpMusicXml\Elements\Clef;
use MuseFx\PhpMusicXml\Elements\Key;
use MuseFx\PhpMusicXml\Elements\Time;

class Stafe
{
    /**
     * @var Clef
     */
    protected Clef $clef;

    /**
     * @param Clef $clef
     */
    public function __construct(Clef $clef)
    {
        $this->clef = $clef;
    }

    /**
     * @return Clef|null
     */
    public function getClef(): ?Clef
    {
        return $this->clef;
    }

    /**
     * @param int $number
     *
     * @return self
     */
    public function setNumber(int $number): self
    {
        $this->clef->setAttribute('number', $number);

        return $this;
    }

    /**
     * @return int
     */
    public function getNumber(): int
    {
        return (int) $this->clef->getAttribute('number') ?: 1;
    }
}
