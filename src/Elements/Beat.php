<?php

namespace MuseFx\PhpMusicXml\Elements;

use MuseFx\PhpMusicXml\Helpers\NoteCalculator;
use MuseFx\PhpMusicXml\MusicXml;
use Closure;

abstract class Beat extends Element
{
    public const TYPE_LONG = 'long';
    public const TYPE_BREVE = 'breve';
    public const TYPE_WHOLE = 'whole';
    public const TYPE_HALF = 'half';
    public const TYPE_QUARTER = 'quarter';
    public const TYPE_EIGHTH = 'eighth';
    public const TYPE_16TH = '16th';
    public const TYPE_32ND = '32nd';
    public const TYPE_64TH = '64th';
    public const TYPE_128TH = '128th';
    public const TYPE_256TH = '256th';
    public const TYPE_512TH = '512th';
    public const TYPE_1024TH = '1024th';

    /**
     * @var CustomElement
     */
    protected CustomElement $type;

    /**
     * @var CustomElement|null
     */
    protected ?CustomElement $duration;

    /**
     * @var CustomElement|null
     */
    protected ?CustomElement $dot;

    /**
     * @var CustomElement|null
     */
    protected ?CustomElement $stem;

    /**
     * @var CustomElement|null
     */
    protected ?CustomElement $staff;

    /**
     * @var CustomElement|null
     */
    protected ?CustomElement $voice;

    /**
     * @var CustomElement|null
     */
    protected ?CustomElement $instrument;

    /**
     * @var TimeModification|null
     */
    protected ?TimeModification $timeModification;

    /**
     * @var Notations|null
     */
    protected ?Notations $notations;

    /**
     * @param MusicXml $document
     * @param string $type
     */
    public function __construct(MusicXml $document, string $type = self::TYPE_QUARTER)
    {
        parent::__construct($document);

        $this->type = new CustomElement($this->document, 'type');
        $this->type->setValue($type);
        $this->addElement($this->type);
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type->getValue();
    }

    /**
     * @param string $type
     *
     * @return self
     */
    public function setType(string $type): self
    {
        $this->type->setValue($type);

        return $this;
    }

    /**
     * @return self
     */
    public function dot(): self
    {
        $this->dot = new CustomElement($this->document, 'dot');
        $this->addElement($this->dot);

        return $this;
    }

    /**
     * @param int $into
     * @param int $from
     *
     * @return self
     */
    public function setTimeModification(int $into = 3, int $from = 2): self
    {
        if (empty($this->timeModification)) {
            $this->timeModification = new TimeModification(
                $this->document,
                $into,
                $from,
                $this->getType()
            );
            $this->addElement($this->timeModification);
        } else {
            $this->timeModification
                ->setActualNotes($into)
                ->setNormalNotes($from)
                ->setNormalType($this->getType());
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isDotted(): bool
    {
        return !empty($this->dot);
    }

    /**
     * @return bool
     */
    public function isTuplet(): bool
    {
        return !empty($this->timeModification);
    }

    /**
     * @return TimeModification|null
     */
    public function getTimeModification(): ?TimeModification
    {
        return $this->timeModification;
    }

    /**
     * @return self
     */
    public function startTie(): self
    {
        $binding = new CustomElement($this->document, 'tie');
        $binding->setAttribute('type', 'start');
        $this->addElement($binding);

        return $this->addNotation('tied', [
            'type' => 'start',
        ]);
    }

    /**
     * @return self
     */
    public function stopTie(): self
    {
        $binding = new CustomElement($this->document, 'tie');
        $binding->setAttribute('type', 'stop');
        $this->addElement($binding);

        return $this->addNotation('tied', [
            'type' => 'stop',
        ]);
    }

    /**
     * @return self
     */
    public function letRing(): self
    {
        return $this->addNotation('tied', [
            'type' => 'let-ring',
        ]);
    }

    /**
     * @param int $number
     *
     * @return self
     */
    public function startSlur(int $number = 1): self
    {
        return $this->addNotation('slur', [
            'type' => 'start',
            'number' => $number,
        ]);
    }

    /**
     * @param int $number
     *
     * @return self
     */
    public function stopSlur(int $number = 1): self
    {
        return $this->addNotation('slur', [
            'type' => 'stop',
            'number' => $number,
        ]);
    }

    /**
     * @param string $notation
     * @param array $attributes
     * @param Closure|null $callback
     *
     * @return self
     */
    public function addNotation(string $notation, array $attributes = [], ?Closure $callback = null): self
    {
        $notation = new CustomElement($this->document, $notation);
        foreach ($attributes as $key => $value) {
            $notation->setAttribute($key, $value);
        }

        if (is_callable($callback)) {
            $callback($notation);
        }

        $this->createNotations();
        $this->notations->addElement($notation);

        return $this;
    }

    /**
     * @param string $articulation
     * @param array $attributes
     * @param Closure|null $callback
     *
     * @return self
     */
    public function addArticulation(string $articulation, array $attributes = [], ?Closure $callback = null): self
    {
        $this->createNotations();
        $this->notations->addArticulation($articulation, $attributes, $callback);

        return $this;
    }

    /**
     * @param NoteCalculator $noteCalculator
     *
     * @return float
     */
    public function setDuration(NoteCalculator $noteCalculator)
    {
        $duration = $noteCalculator->getNoteDuration($this);
        $this->createDurationElement()->setValue($duration);

        return $duration;
    }

    /**
     * @return CustomElement|null
     */
    public function getDurationElement(): ?CustomElement
    {
        return $this->createDurationElement();
    }

    /**
     * @return CustomElement
     */
    protected function createDurationElement(): CustomElement
    {
        if (empty($this->duration)) {
            $this->duration = new CustomElement($this->document, 'duration');
            $this->addElement($this->duration);
        }

        return $this->duration;
    }

    /**
     * @return void
     */
    protected function createNotations(): void
    {
        if (empty($this->notations)) {
            $this->notations = new Notations($this->document);
            $this->addElement($this->notations);
        }
    }

    /**
     * @return self
     */
    public function stemUp(): self
    {
        $this->getStem()->setValue('up');

        return $this;
    }

    /**
     * @return self
     */
    public function stemDown(): self
    {
        $this->getStem()->setValue('down');

        return $this;
    }

    /**
     * @return CustomElement
     */
    protected function getStem(): CustomElement
    {
        if (empty($this->stem)) {
            $this->stem = new CustomElement($this->document, 'stem');
            $this->addElement($this->stem);
        }

        return $this->stem;
    }

    /**
     * @param int $number
     *
     * @return self
     */
    public function startBeam(int $number = 1): self
    {
        $beam = new CustomElement($this->document, 'beam');
        $beam->setAttribute('number', $number);
        $beam->setValue('begin');
        $this->addElement($beam);

        return $this;
    }

    /**
     * @param int $number
     *
     * @return self
     */
    public function endBeam(int $number = 1): self
    {
        $beam = new CustomElement($this->document, 'beam');
        $beam->setAttribute('number', $number);
        $beam->setValue('end');
        $this->addElement($beam);

        return $this;
    }

    /**
     * @param int $number
     *
     * @return self
     */
    public function continueBeam(int $number = 1): self
    {
        $beam = new CustomElement($this->document, 'beam');
        $beam->setAttribute('number', $number);
        $beam->setValue('continue');
        $this->addElement($beam);

        return $this;
    }

    /**
     * @param int $stafeNo
     *
     * @return self
     */
    public function toStafe(int $stafeNo = 1): self
    {
        if (empty($this->staff)) {
            $this->staff = new CustomElement($this->document, 'staff');
            $this->addElement($this->staff);
        }

        $this->staff->setValue($stafeNo);

        return $this;
    }

    /**
     * @return int
     */
    public function getStafe(): int
    {
        return (int) $this->createStaff()->getValue();
    }

    /**
     * @return CustomElement
     */
    protected function createStaff(): CustomElement
    {
        if (empty($this->staff)) {
            $this->staff = new CustomElement($this->document, 'staff');
            $this->staff->setValue(1);
            $this->addElement($this->staff);
        }

        return $this->staff;
    }

    /**
     * @param int $voiceNum
     *
     * @return self
     */
    public function toVoice(int $voiceNum = 1): self
    {
        $this->createVoice()->setValue($voiceNum);
        return $this;
    }

    /**
     * @return int
     */
    public function getVoice(): int
    {
        return (int) $this->createVoice()->getValue();
    }

    /**
     * @return CustomElement
     */
    protected function createVoice(): CustomElement
    {
        if (empty($this->voice)) {
            $this->voice = new CustomElement($this->document, 'voice');
            $this->voice->setValue(1);
            $this->addElement($this->voice);
        }

        return $this->voice;
    }

    /**
     * @param Measure $measure
     *
     * @return self
     */
    public function addToMeasure(Measure $measure): self
    {
        $measure->addElement($this);
        return $this;
    }

    /**
     * @param mixed $instrumentId
     *
     * @return self
     */
    public function withInstrument($instrumentId): self
    {
        $this->createInstrument()->setAttribute('id', $instrumentId);
        return $this;
    }

    /**
     * @return CustomElement
     */
    protected function createInstrument(): CustomElement
    {
        if (empty($this->instrument)) {
            $this->instrument = new CustomElement($this->document, 'instrument');
            $this->addElement($this->instrument);
        }

        return $this->instrument;
    }
}
