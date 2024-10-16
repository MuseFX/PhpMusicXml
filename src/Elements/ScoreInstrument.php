<?php

namespace MuseFx\PhpMusicXml\Elements;

class ScoreInstrument extends Element
{
    /**
     * @var CustomElement
     */
    public CustomElement $name;

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = new CustomElement($this->document, 'instrument-name');
        $this->name->setValue($name);
        $this->addElement($this->name);

        return $this;
    }
}
