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
        $controller = new \atoum\mock\controller();
        $controller->__construct = function() {};
        $request = new \mock\Wizacha\UniversignBundle\Transaction\TransactionRequest([],'','',[],'','', $controller);
        $request->getMockController()->getArrayCopy = ['successURL' => $return_url, 'customId' => 'myId'];
        $expected_response = new \Wizacha\UniversignBundle\Transaction\TransactionResponse(
            [
                'url' => $return_url,
                'id'  => 'myId',
            ]
        );
        $this
            ->object($manager->requestTransaction($request))
                ->isEqualTo($expected_response);
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
            ->array($document)
            ->object(reset($document))
                ->isInstanceOf('Wizacha\UniversignBundle\Document\TransactionDocument')
            ->array(reset($document)->getArrayCopy())
                ->isEqualTo([
                    'content'   => $custom_id.'content',
                    'name'      => $custom_id.'.doc'
                ])
        ;
    }
}