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
use Wizacha\UniversignBundle\Document\DocumentSimple as TestedDocumentSimple;

class DocumentSimple extends atoum
{
    public function testDocumentSimple()
    {
        $doc = new TestedDocumentSimple();
        $doc->setContent('my content');
        $doc->setName('my name');
        $this->array($doc->getArrayData())->isEqualTo(['content' => 'my content', 'name' => 'my name']);
    }
}