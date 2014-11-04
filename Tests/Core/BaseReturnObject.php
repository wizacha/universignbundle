<?php
/**
 * This file is part of the WizachaUniversign bundle.
 *
 * (c) Wizacha <dev-team@wizacha.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Wizacha\UniversignBundle\Core\tests\units;

use \atoum;

class BaseReturnObject extends atoum
{
    public function testConstructor()
    {
        $data = [
            'status'            => 'status_code',
            'error'             => 'error_string',
            'url'               => 'sign_url',
        ];
        $object = new \Wizacha\UniversignBundle\Core\BaseReturnObject($data);
        $this
            ->array($object->getRawData())->isEqualTo($data)
        ;
    }
}