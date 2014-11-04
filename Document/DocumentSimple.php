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

use Wizacha\UniversignBundle\Core\BaseReturnObject;
use Wizacha\UniversignBundle\Core\CoreSendObjectInterface;

class DocumentSimple extends BaseReturnObject implements CoreSendObjectInterface
{
    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->datas['content'] = $content;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->datas['name'] = $name;
    }

    public function getArrayData()
    {
        return $this->datas;
    }
}