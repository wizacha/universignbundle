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
use \mock\Wizacha\UniversignBundle\Request\RequestManager as TestedManager;
use Wizacha\UniversignBundle\Document\TransactionDocument;
use Wizacha\UniversignBundle\Signer\TransactionSigner;
use Wizacha\UniversignBundle\Transaction\TransactionInfo;
use Wizacha\UniversignBundle\Transaction\TransactionRequest;
use Wizacha\UniversignBundle\Transaction\TransactionResponse;

class WorkAroudSend
{
    protected $error_level;
    public function __construct()
    {
        $this->error_level = error_reporting();
        error_reporting(E_WARNING);
    }
    public function __destruct()
    {
        error_reporting($this->error_level);
    }
}


class RequestManager extends atoum
{
    public function testRequestTransactionConvertRequestAndCheckErrors()
    {
        $prefix = 'prefix';
        $request = $this->getMockTransactionRequest(
            [
                'customId'              => 'custom_id',
                'successURL'            => 'success_url',
                'signers'               => [[
                    'firstname'     => 'sign_firstname',
                    'lastname'      => 'sign_lastname',
                    'organization'  => 'sign_organization',
                    'emailAddress'  => 'sign_email_address',
                    'phoneNum'      => 'sign_phone_num',
                ]],
                'identificationType'    => 'sms',
                'language'              => 'fr',
                'documents'             => [
                    ['content' => 'plop_content', 'name' => 'plop']
                ],
            ]
        );

        $expected_request = new \xmlrpcval([
            'customId'              => new \xmlrpcval('custom_id'),
            'successURL'            => new \xmlrpcval('success_url'),
            'signers'               => new \xmlrpcval(
                [
                    new \xmlrpcval(
                        [
                            'firstname'     => new \xmlrpcval('sign_firstname'),
                            'lastname'      => new \xmlrpcval('sign_lastname'),
                            'organization'  => new \xmlrpcval('sign_organization'),
                            'emailAddress'  => new \xmlrpcval('sign_email_address'),
                            'phoneNum'      => new \xmlrpcval('sign_phone_num'),
                        ],
                        'struct')
                ],
                'array'
            ),
            'identificationType'    => new \xmlrpcval('sms'),
            'language'              => new \xmlrpcval('fr'),
            'documents'             => new \xmlrpcval(
                [
                    new \xmlrpcval(
                        [
                            'content' => new \xmlrpcval('plop_content', 'base64'),
                            'name' => new \xmlrpcval('plop')
                        ],
                        'struct'
                    )
                ],
                'array'
            )
            ],
            'struct'
        );
        $expected_request = new \xmlrpcmsg('requester.requestTransaction',[$expected_request]);

        $send_return_value = new \xmlrpcval(
            [
                'data' => new \xmlrpcval('hello world', 'string'),
            ],
            'struct'
        );
        $client = $this->getMockXmlrpcClient(new \xmlrpcresp($send_return_value));

        $manager = new TestedManager($client, $prefix);
        $temp = new WorkAroudSend();
        $retour = $manager->requestTransaction($request);
        unset($temp);

        $this
            ->mock($request)
                ->call('setPrefix')
                    ->withArguments($prefix)
                        ->once()
            ->mock($client)
                ->call('send')
                    ->withArguments($expected_request)
                        ->once()
            ->mock($manager)
                ->call('handleErrors')
                    ->once()
            ->object($retour)
                ->isEqualTo(new TransactionResponse(['data' => 'hello world']))
        ;
    }


    public function testGetTransactionInfoByCustomIdSendCorrectRequest()
    {
        $custom_id = 'my_id';
        $prefix = 'prefix';
        $expected_request = new \xmlrpcmsg('requester.getTransactionInfoByCustomId', [new \xmlrpcval($prefix.$custom_id, 'string')]);
        $send_return_value = new \xmlrpcval(
            [
                'data' => new \xmlrpcval('hello world', 'string'),
            ],
            'struct'
        );
        $client = $this->getMockXmlrpcClient(new \xmlrpcresp($send_return_value));
        $manager = new TestedManager($client, $prefix);
        $temp = new WorkAroudSend();
        $retour = $manager->getTransactionInfoByCustomId($custom_id);
        unset($temp);
        $this
            ->mock($client)
                ->call('send')
                    ->withArguments($expected_request)
                        ->once()
            ->mock($manager)
                ->call('handleErrors')
                    ->once()
            ->object($retour)
                ->isEqualTo(new TransactionInfo(['data' => 'hello world']))
        ;
    }

    public function testGetDocumentsByCustomId()
    {
        $custom_id = 'my_id';
        $prefix = 'prefix';
        $expected_request = new \xmlrpcmsg('requester.getDocumentsByCustomId', [new \xmlrpcval($prefix.$custom_id, 'string')]);
        $send_return_value = new \xmlrpcval(
            [
                'content' => new \xmlrpcval('hello world', 'base64'),
                'name' => new \xmlrpcval('doc_name')
            ],
            'struct'
        );
        $client = $this->getMockXmlrpcClient(new \xmlrpcresp($send_return_value));

        $manager = new TestedManager($client, $prefix);
        $temp = new WorkAroudSend();
        $retour = $manager->getDocumentsByCustomId($custom_id);
        unset($temp);
        $this
            ->mock($client)
                ->call('send')
                    ->withArguments($expected_request)
                        ->once()
            ->mock($manager)
                ->call('handleErrors')
                    ->once()
            ->object($retour)
                ->isEqualTo(new TransactionDocument(['content' => 'hello world', 'name' => 'doc_name']))
        ;

    }

    public function testConvertXmlValueWithEmptyData()
    {
        $manager = new TestedManager($this->getMockXmlrpcClient('value'));
        $this->variable($manager->convertXmlValue(null))->isNull();
    }

    public function testConvertXmlValueWithComplexValue()
    {
        $raw_data = new \xmlrpcval([
                'customId'              => new \xmlrpcval('custom_id'),
                'successURL'            => new \xmlrpcval('success_url'),
                'signers'               => new \xmlrpcval(
                        [
                            new \xmlrpcval(
                                [
                                    'firstname'     => new \xmlrpcval('sign_firstname'),
                                    'lastname'      => new \xmlrpcval('sign_lastname'),
                                    'organization'  => new \xmlrpcval('sign_organization'),
                                    'emailAddress'  => new \xmlrpcval('sign_email_address'),
                                    'phoneNum'      => new \xmlrpcval('sign_phone_num'),
                                    'birthDate'     => new \xmlrpcval('1985-12-14', 'dateTime.iso8601')
                                ],
                                'struct')
                        ],
                        'array'
                    ),
                'identificationType'    => new \xmlrpcval('sms'),
                'language'              => new \xmlrpcval('fr'),
                'documents'             => new \xmlrpcval(
                        [
                            new \xmlrpcval(
                                [
                                    'content' => new \xmlrpcval('plop_content', 'base64'),
                                    'name' => new \xmlrpcval('plop')
                                ],
                                'struct'
                            )
                        ],
                        'array'
                    )
            ],
            'struct'
        );

        $expected = [
            'customId'              => 'custom_id',
            'successURL'            => 'success_url',
            'signers'               => [[
                'firstname'     => 'sign_firstname',
                'lastname'      => 'sign_lastname',
                'organization'  => 'sign_organization',
                'emailAddress'  => 'sign_email_address',
                'phoneNum'      => 'sign_phone_num',
                'birthDate'     => '1985-12-14'
            ]],
            'identificationType'    => 'sms',
            'language'              => 'fr',
            'documents'             => [
                ['content' => 'plop_content', 'name' => 'plop']
            ],
        ];

        $client = $this->getMockXmlrpcClient(new \xmlrpcresp('test'));
        $manager = new TestedManager($client);
        $this->array($manager->convertXmlValue($raw_data))->isEqualTo($expected);


    }
    public function testHandleErrorThrowExceptionIfErrorOccurs()
    {
        $response = new \xmlrpcresp('val', 5, 'erreur');
        $manager = new TestedManager($this->getMockXmlrpcClient('value'));
        $this->exception(function () use ($manager, $response) {$manager->handleErrors($response);});
    }

    protected function getMockTransactionRequest($get_array_data_value = [])
    {
        $controller = new \atoum\mock\controller();
        $controller->__construct = function() {};
        $return = new \mock\Wizacha\UniversignBundle\Transaction\TransactionRequest([],'','',[],'','', $controller);
        $return->getMockController()->getArrayCopy = $get_array_data_value;
        return $return;
    }

    protected function getMockXmlrpcClient($send_return)
    {
        $client = new \mock\xmlrpc_client("https://login:password@example.com");
        $client->getMockController()->send = $send_return;
        return $client;
    }
}