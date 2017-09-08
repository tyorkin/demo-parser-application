<?php

namespace Tyorkin\HyperParserApplication\Document;

use MongoDB\BSON\Unserializable;
use MongoDB\BSON\Serializable;
use MongoDB\BSON\ObjectId;


class Url implements DocumentInterface, Unserializable, Serializable
{
    /**
     * @var string
     */
    private $url = '';
    /**
     * @var int
     */
    private $titleTagLength = 0;
    /**
     * @var int
     */
    private $descriptionTagLength = 0;
    /**
     * @var int
     */
    private $h1TagLength = 0;
    /**
     * @var int
     */
    private $imgTagCount = 0;
    /**
     * @var int
     */
    private $aTagCount = 0;
    /**
     * @var int
     */
    private $pTagsTextLength = 0;
    /**
     * @var int
     */
    private $pTagsTextLengthWithoutSpaces = 0;
    /**
     * @var bool
     */
    private $isProcessed = false;

    /**
     * @var bool
     */
    private $isFoundInSitemap = false;


    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return Url
     */
    public function setUrl($url)
    {
        $this->url = (string) $url;
        return $this;
    }

    /**
     * @return int
     */
    public function getTitleTagLength()
    {
        return $this->titleTagLength;
    }

    /**
     * @param int $titleTagLength
     * @return Url
     */
    public function setTitleTagLength($titleTagLength)
    {
        $this->titleTagLength = (int) $titleTagLength;
        return $this;
    }

    /**
     * @return int
     */
    public function getDescriptionTagLength()
    {
        return $this->descriptionTagLength;
    }

    /**
     * @param int $descriptionTagLength
     * @return Url
     */
    public function setDescriptionTagLength($descriptionTagLength)
    {
        $this->descriptionTagLength = (int) $descriptionTagLength;
        return $this;
    }

    /**
     * @return int
     */
    public function getH1TagLength()
    {
        return $this->h1TagLength;
    }

    /**
     * @param int $h1TagLength
     * @return Url
     */
    public function setH1TagLength($h1TagLength)
    {
        $this->h1TagLength = (int) $h1TagLength;
        return $this;
    }

    /**
     * @return int
     */
    public function getImgTagCount()
    {
        return $this->imgTagCount;
    }

    /**
     * @param int $imgTagCount
     * @return Url
     */
    public function setImgTagCount($imgTagCount)
    {
        $this->imgTagCount = (int) $imgTagCount;
        return $this;
    }

    /**
     * @return int
     */
    public function getATagCount()
    {
        return $this->aTagCount;
    }

    /**
     * @param int $aTagCount
     * @return Url
     */
    public function setATagCount($aTagCount)
    {
        $this->aTagCount = (int) $aTagCount;
        return $this;
    }

    /**
     * @return int
     */
    public function getPTagsTextLength()
    {
        return $this->pTagsTextLength;
    }

    /**
     * @param int $pTagsTextLength
     * @return Url
     */
    public function setPTagsTextLength($pTagsTextLength)
    {
        $this->pTagsTextLength = (int) $pTagsTextLength;
        return $this;
    }

    /**
     * @return bool
     */
    public function isProcessed()
    {
        return $this->isProcessed;
    }

    /**
     * @param bool $isProcessed
     * @return Url
     */
    public function setIsProcessed($isProcessed)
    {
        $this->isProcessed = (bool) $isProcessed;
        return $this;
    }

    /**
     * @return int
     */
    public function getPTagsTextLengthWithoutSpaces(): int
    {
        return $this->pTagsTextLengthWithoutSpaces;
    }

    /**
     * @param int $pTagsTextLengthWithoutSpaces
     *
     * @return self
     */
    public function setPTagsTextLengthWithoutSpaces(int $pTagsTextLengthWithoutSpaces)
    {
        $this->pTagsTextLengthWithoutSpaces = $pTagsTextLengthWithoutSpaces;
        return $this;
    }

    /**
     * @return bool
     */
    public function isFoundInSitemap(): bool
    {
        return $this->isFoundInSitemap;
    }

    /**
     * @param bool $isFoundInSitemap
     *
     * @return self
     */
    public function setIsFoundInSitemap(bool $isFoundInSitemap)
    {
        $this->isFoundInSitemap = $isFoundInSitemap;
        return $this;
    }



    public function bsonUnserialize(array $data)
    {
        //$this->id = $data['_id'];
        $this->setUrl($data['url']);
        $this->setTitleTagLength($data['titleTagLength']);
        $this->setDescriptionTagLength($data['descriptionTagLength']);
        $this->setH1TagLength($data['h1TagLength']);
        $this->setImgTagCount($data['imgTagCount']);
        $this->setATagCount($data['aTagCount']);
        $this->setPTagsTextLength($data['pTagsTextLength']);
        $this->setPTagsTextLengthWithoutSpaces($data['pTagsTextLengthWithoutSpaces']);
        $this->setIsProcessed($data['isProcessed']);
        $this->setIsFoundInSitemap($data['isFoundInSitemap']);
    }

    /**
     * @return array
     */
    public function bsonSerialize(): array
    {
        //$data['_id'] = $this->id ? $this->id : new ObjectId();
        $data = [];
        $data['url'] = $this->getUrl();
        $data['titleTagLength'] = $this->getTitleTagLength();
        $data['descriptionTagLength'] = $this->getDescriptionTagLength();
        $data['h1TagLength'] = $this->getH1TagLength();
        $data['imgTagCount'] = $this->getImgTagCount();
        $data['aTagCount'] = $this->getATagCount();
        $data['pTagsTextLength'] = $this->getPTagsTextLength();
        $data['pTagsTextLengthWithoutSpaces'] = $this->getPTagsTextLengthWithoutSpaces();
        $data['isProcessed'] = $this->isProcessed();
        $data['isFoundInSitemap'] = $this->isFoundInSitemap();

        return $data;
    }


}