<?php

namespace MuseFx\PhpMusicXml\Elements;

use Closure;

class Notations extends Element
{
    protected Articulations $articulations;

    /**
     * @param string $articulation
     * @param array $attributes
     * @param Closure|null $callback
     *
     * @return self
     */
    public function addArticulation(string $articulation, array $attributes, ?Closure $callback = null): self
    {
        if (empty($this->articulations)) {
            $this->articulations = new Articulations($this->document);
            $this->addElement($this->articulations);
        }
        $articulation = new CustomElement($this->document, $articulation);

        foreach ($attributes as $key => $value) {
            $articulation->setAttribute($key, $value);
        }

        if (is_callable($callback)) {
            $callback($articulation);
        }

        $this->articulations->addElement($articulation);

        return $this;
    }
}
