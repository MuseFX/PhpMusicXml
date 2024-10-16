<?php

namespace MuseFx\PhpMusicXml\Helpers;

use MuseFx\PhpMusicXml\Elements\Beat;
use MuseFx\PhpMusicXml\Elements\Measure;
use MuseFx\PhpMusicXml\Exceptions\Exception as MusicXmlException;
use MuseFx\PhpMusicXml\Exceptions\MusicTheoryException;

class NoteCalculator
{
    /**
     * @var Measure
     */
    protected Measure $measure;

    /**
     * @var array
     */
    protected array $noteValues = [
        Beat::TYPE_LONG => 4,
        Beat::TYPE_BREVE => 2,
        Beat::TYPE_WHOLE => 1,
        Beat::TYPE_HALF => 2,
        Beat::TYPE_QUARTER => 4,
        Beat::TYPE_EIGHTH => 8,
        Beat::TYPE_16TH => 16,
        Beat::TYPE_32ND => 32,
        Beat::TYPE_64TH => 64,
        Beat::TYPE_128TH => 128,
        Beat::TYPE_256TH => 256,
        Beat::TYPE_512TH => 512,
        Beat::TYPE_1024TH => 1024,
    ];

    /**
     * @param Measure|null $measure
     */
    public function __construct(Measure $measure = null)
    {
        $this->measure = $measure;
    }

    /**
     * @return float
     */
    public function getMeasureLength(): float
    {
        return $this->measure->getTime()->getBeats() * $this->multiplier();
    }

    /**
     * @param string $noteType
     *
     * @return float
     */
    public function getNoteTypeDuration(string $noteType): float
    {
        $noteValue = $this->noteValues[$noteType] ?? null;
        if (empty($noteValue)) {
            throw new MusicXmlException('Note type `' . $noteType . '` not defined');
        }

        return 1 / ($noteValue / ($this->measure->getTime()->getBeatType() ?: 1));
    }

    /**
     * @return float
     */
    public function getDivision(): float
    {
        return $this->getNoteTypeDuration(Beat::TYPE_QUARTER) * $this->multiplier();
    }

    /**
     * @param Beat $note
     *
     * @return float
     */
    public function getNoteDuration(Beat $note): float
    {
        $duration = $this->getNoteTypeDuration($note->getType());
        if ($note->isDotted()) {
            $duration += $duration / 2;
        }
        if ($note->isTuplet()) {
            $duration *= $note->getTimeModification()->getNormalNotes();
            $duration /= $note->getTimeModification()->getActualNotes();
        }
        return $duration * $this->multiplier();
    }

    /**
     * @param bool $checkMeasures
     *
     * @return array
     * @throws MusicTheoryException
     */
    public function checkMeasureLength($checkMeasures = true): array
    {
        $staves = $this->measure->getStaves();
        foreach ($staves as $stafe) {
            $notes = array_filter($this->measure->getNotes(), function (Beat $note) use ($stafe) {
                return $note->getStafe() == $stafe->getNumber();
            });

            $voices = [];
            foreach ($notes as $note) {
                $voices[$note->getVoice()][] = $note;
            }

            foreach ($voices as $voiceId => $notes) {
                $thisLength = 0;
                foreach ($notes as $note) {
                    $thisLength += $note->setDuration($this);
                }
                if ($checkMeasures && bccomp($thisLength, $this->getMeasureLength(), 20) != 0) {
                    $thisSize = $thisLength / $this->getMeasureLength();
                    $neededSize = $this->measure->getTime()->getBeats();
                    $thisSize *= $this->measure->getTime()->getBeats();
                    throw new MusicTheoryException(
                        'Incorrect measure length: ' . $thisSize . ' / ' . $neededSize . '.'
                    );
                }
            }
        }

        return [
            'length' => $thisLength ?? 0,
            'measureLength' => $this->getMeasureLength(),
        ];
    }

    /**
     * @return int
     */
    protected function multiplier(): int
    {
        $minimumBeatType = 4;
        $diff = $this->measure->getTime()->getBeats() - $minimumBeatType;
        if ($diff < 0) {
            return 10;
        }

        return 1;
    }
}
