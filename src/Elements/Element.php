<?php

namespace MuseFx\PhpMusicXml\Elements;

use MuseFx\PhpMusicXml\MusicXml;
use DOMDocument;
use DOMNode;

abstract class Element
{
    /**
     * @var string|null|null
     */
    protected ?string $elementName = null;

    /**
     * @var DOMNode
     */
    protected DOMNode $element;

    /**
     * @var MusicXml
     */
    protected MusicXml $document;

    /**
     * @param MusicXml $document
     */
    public function __construct(MusicXml $document)
    {
        $this->document = $document;
        $this->element = $this->document->getDocument()->createElement(
            $this->getElementName()
        );
    }

    /**
     * @return string
     */
    public function getElementName(): string
    {
        if (!empty($this->elementName)) {
            return $this->elementName;
        }

        $className = current(array_reverse(explode('\\', get_class($this))));
        return strtolower(trim(preg_replace('/([A-Z])/', '-$1', $className), '-'));
    }

    /**
     * @param self $element
     *
     * @return self
     */
    public function addElement(self $element): self
    {
        $this->getElement()->appendChild($element->getElement());

        return $this;
    }

    /**
     * @return DOMNode
     */
    public function getElement(): DOMNode
    {
        return $this->element;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->element->nodeValue;
    }

    /**
     * @param mixed $value
     *
     * @return self
     */
    public function setValue($value): self
    {
        $this->element->nodeValue = $value;

        return $this;
    }

    /**
     * @return MusicXml
     */
    public function getDocument(): MusicXml
    {
        return $this->document;
    }

    /**
     * @param mixed $attribute
     * @param mixed $value
     *
     * @return self
     */
    public function setAttribute($attribute, $value): self
    {
        $this->element->setAttribute($attribute, $value);

        return $this;
    }

    /**
     * @param string $attribute
     *
     * @return mixed
     */
    public function getAttribute(string $attribute)
    {
        return $this->element->getAttribute($attribute);
    }
}
