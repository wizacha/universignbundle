<?php
/**
 * This file is part of the WizachaUniversign bundle.
 *
 * (c) Wizacha <dev-team@wizacha.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Wizacha\UniversignBundle\Document\tests\units;

use \atoum;
use Wizacha\UniversignBundle\Document\TransactionDocument as TestedTransactionDocument;

class TransactionDocument extends atoum
{
    public function testTransactionDocument()
    {
        $doc = new TestedTransactionDocument();
        $doc->setContent('my content');
        $doc->setName('my name');
        $this->array($doc->getArrayData())->isEqualTo(['content' => 'my content', 'name' => 'my name']);
    }
}