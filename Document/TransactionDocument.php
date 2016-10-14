<?php
/**
 * This file is part of the WizachaUniversign bundle.
 *
 * (c) Wizacha <dev-team@wizacha.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Wizacha\UniversignBundle\Document;

/**
 * Class TransactionDocument
 * this class is used for output and input data.
 * @package Wizacha\UniversignBundle
 */
class TransactionDocument extends \ArrayObject
{
    /**
     * @var array
     *
     * Required values : {"page" => "Page number", "x" => "X coordinates", "y" => "Y coordinates", "signerIndex" => "Signer index"}
     * Optional values : {"name" => "Name of the signature field"}
     */
    protected $signatureFields = [];

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->offsetSet('content', $content);
    }

    /**
     * @return string|null
     */
    public function getContent()
    {
        return @$this['content'];
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->offsetSet('name', $name);
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return @$this['name'];
    }

    /**
     * @param array $signatureField
     */
    public function addSignatureField(array $signatureField)
    {
        $this->signatureFields[] = $signatureField;
        $this->offsetSet('signatureFields', $this->signatureFields);
    }

    /**
     * @param array $signatureField
     */
    public function setSignatureFields(array $signatureField)
    {
        $this->signatureFields = $signatureField;
        $this->offsetSet('signatureFields', $signatureField);
    }

    /**
     * @return mixed
     */
    public function getSignatureFields()
    {
        return @$this['signatureFields'];
    }
}