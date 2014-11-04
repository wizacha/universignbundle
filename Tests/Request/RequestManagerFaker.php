<?php
/**
 * This file is part of the WizachaUniversign bundle.
 *
 * (c) Wizacha <dev-team@wizacha.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Wizacha\UniversignBundle\Request\tests\units;

use \atoum;
use Wizacha\UniversignBundle\Request\RequestManagerFaker as TestedManager;
use Wizacha\UniversignBundle\Transaction\TransactionInfo;

class RequestManagerFaker extends atoum
{
    public function testRequestTransactionReturnSuccessURL()
    {
        $manager = new TestedManager();
        $return_url = 'http://example.com/returnURL';
        $request = new \mock\Wizacha\UniversignBundle\Core\CoreSendObjectInterface();
        $request->getMockController()->getArrayData = ['successURL' => $return_url];
        $this
            ->string($manager->requestTransaction($request))
                ->isEqualTo($return_url);
    }

    public function testGetTransactionInfoByCustomIdReturnSuccessedTransaction()
    {
        $manager = new TestedManager();
        $transaction_info = $manager->getTransactionInfoByCustomId('customID');
        $this
            ->object($transaction_info)
                ->isInstanceOf('Wizacha\UniversignBundle\Transaction\TransactionInfo')
            ->string($transaction_info->getStatus())
                ->isEqualTo(TransactionInfo::STATUS_COMPLETED)
        ;
    }

    public function testGetDocumentsByCustomIdGenerateDocument()
    {
        $manager = new TestedManager();
        $custom_id = 'customID';
        $document = $manager->getDocumentsByCustomId($custom_id);
        $this
            ->object($document)
                ->isInstanceOf('Wizacha\UniversignBundle\Document\DocumentSimple')
            ->array($document->getData())
                ->isEqualTo([
                    'content'   => $custom_id.'content',
                    'name'      => $custom_id.'.doc'
                ])
        ;
    }
}