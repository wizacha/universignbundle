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

use Wizacha\UniversignBundle\Core\CoreSendObjectInterface;

/**
 * Class TransactionDocument
 * this class is used like output and input data.
 * @package Wizacha\UniversignBundle\Document
 */
class TransactionDocument extends \ArrayObject implements CoreSendObjectInterface
{
    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->offsetSet('content', $content);
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->offsetSet('name', $name);
    }

    public function getArrayData()
    {
        return $this->getArrayCopy();
    }
}