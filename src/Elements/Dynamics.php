<?php

namespace MuseFx\PhpMusicXml\Elements;

use MuseFx\PhpMusicXml\Exceptions\Exception;
use MuseFx\PhpMusicXml\MusicXml as MusicXmlException;

class Dynamics extends Element
{
    protected CustomElement $dynamicsSign;

    /**
     * @return void
     */
    public function pppp(): void
    {
        $this->setDynamics('pppp');
    }

    /**
     * @return void
     */
    public function ppp(): void
    {
        $this->setDynamics('ppp');
    }

    /**
     * @return void
     */
    public function pp(): void
    {
        $this->setDynamics('pp');
    }

    /**
     * @return void
     */
    public function p(): void
    {
        $this->setDynamics('p');
    }

    /**
     * @return void
     */
    public function mp(): void
    {
        $this->setDynamics('mp');
    }

    /**
     * @return void
     */
    public function mf(): void
    {
        $this->setDynamics('mf');
    }

    /**
     * @return void
     */
    public function f(): void
    {
        $this->setDynamics('f');
    }

    /**
     * @return void
     */
    public function ff(): void
    {
        $this->setDynamics('ff');
    }

    /**
     * @return void
     */
    public function fff(): void
    {
        $this->setDynamics('fff');
    }

    /**
     * @return void
     */
    public function ffff(): void
    {
        $this->setDynamics('ffff');
    }

    /**
     * @return void
     */
    public function fp(): void
    {
        $this->setDynamics('fp');
    }

    /**
     * @return void
     */
    public function pf(): void
    {
        $this->setDynamics('pf');
    }

    /**
     * @return void
     */
    public function sf(): void
    {
        $this->setDynamics('sf');
    }

    /**
     * @return void
     */
    public function sfz(): void
    {
        $this->setDynamics('sfz');
    }

    /**
     * @return void
     */
    public function sff(): void
    {
        $this->setDynamics('sff');
    }

    /**
     * @return void
     */
    public function sffz(): void
    {
        $this->setDynamics('sffz');
    }

    /**
     * @return void
     */
    public function sfp(): void
    {
        $this->setDynamics('sfp');
    }

    /**
     * @return void
     */
    public function rfz(): void
    {
        $this->setDynamics('rfz');
    }

    /**
     * @return void
     */
    public function rf(): void
    {
        $this->setDynamics('rf');
    }

    /**
     * @return void
     */
    public function fz(): void
    {
        $this->setDynamics('fz');
    }

    /**
     * @param string $dynamicsSign
     *
     * @return void
     */
    protected function setDynamics(string $dynamicsSign): void
    {
        if (!empty($this->dynamicsSign)) {
            throw new MusicXmlException('Cannot add more dynamic sign in one direction type.');
        }

        $this->dynamicsSign = new CustomElement($this->document, $dynamicsSign);
        $this->addElement($this->dynamicsSign);
    }
}
