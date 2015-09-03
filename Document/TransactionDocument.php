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
}