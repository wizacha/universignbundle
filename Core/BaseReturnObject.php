<?php
/**
 * This file is part of the WizachaUniversign bundle.
 *
 * (c) Wizacha <dev-team@wizacha.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Wizacha\UniversignBundle\Core;

class BaseReturnObject
{

    /**
     * @var array
     */
    protected $datas = [];

    /**
     * @param array $datas
     */
    public function __construct(array $datas = [])
    {
        $this->datas = $datas;
    }

    public function getRawData()
    {
        return $this->datas;
    }

    /**
     * @param string $field_name
     * @return null|mixes
     */
    protected function getField($field_name)
    {
        if (!array_key_exists($field_name, $this->datas)) {
            return null;
        }
        return $this->datas[$field_name];
    }

}