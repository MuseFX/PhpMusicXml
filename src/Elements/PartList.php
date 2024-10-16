<?php

namespace MuseFx\PhpMusicXml\Elements;

use MuseFx\PhpMusicXml\MusicXml;

class PartList extends Element
{
    /**
     * @var array<\MuseFx\PhpMusicXml\Elements\ScorePart>
     */
    protected array $parts = [];

    /**
     * @param string|null $id
     *
     * @return ScorePart
     */
    public function createScorePart(string $id = null): ScorePart
    {
        if (empty($id)) {
            $id = $this->generatePartId($id);
        }
        $scorePart = new ScorePart($this->document, $id);
        $this->addElement($scorePart);
        $this->parts[$id] = $scorePart;

        return $scorePart;
    }

    /**
     * @return string
     */
    protected function generatePartId(): string
    {
        $prefix = 'PHPMXMLSCOREPART-';
        $ids = array_keys($this->parts);
        $autogenerated = array_map(function ($id) use ($prefix) {
            return (int) str_replace($prefix, '', $id);
        }, $ids);

        return $prefix . str_pad(max($autogenerated ?: [0]) + 1, 2, '0', STR_PAD_LEFT);
    }

    /**
     * @return array<\MuseFx\PhpMusicXml\Elements\ScorePart>
     */
    public function getParts(): array
    {
        return $this->parts;
    }
}
