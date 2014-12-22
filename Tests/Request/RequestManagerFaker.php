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
        $request = new \mock\Wizacha\UniversignBundle\Transaction\TransactionRequest([],'','',[], [], $controller);
        $request->getMockController()->getArrayCopy = ['successURL' => $return_url, 'customId' => 'myId'];
        $response = $manager->requestTransaction($request);
        $this
            ->object($response)
            ->string($response->getUrl())
                ->isEqualTo($return_url)
            ->string($response->getId())
                ->isNotEmpty()
        ;
    }

    public function testRequestTransactionReturnDifferentId()
    {
        $manager = new TestedManager();
        $return_url = 'http://example.com/returnURL';
        $controller = new \atoum\mock\controller();
        $controller->__construct = function() {};
        $request = new \mock\Wizacha\UniversignBundle\Transaction\TransactionRequest([],'','',[], [], $controller);
        $request->getMockController()->getArrayCopy = ['successURL' => $return_url, 'customId' => ''];
        $first_id = $manager->requestTransaction($request)->getId();
        $second_id = $manager->requestTransaction($request)->getId();

        $this
            ->string($first_id)
                ->isNotEqualTo($second_id)
            ->string($first_id)
                ->isNotEmpty()
            ->string($second_id)
                ->isNotEmpty()
        ;
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