<?php
/**
 * This file is part of the WizachaUniversign bundle.
 *
 * (c) Wizacha <dev-team@wizacha.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Wizacha\UniversignBundle\Transaction\tests\units;

use \atoum;
use Wizacha\UniversignBundle\Document\tests\units\TransactionDocument;
use Wizacha\UniversignBundle\Transaction\TransactionRequest as TestedTransactionRequest;


class TransactionRequest extends atoum
{
    public function testGetArrayCopyReturnCorrectData()
    {


        $request = new TestedTransactionRequest(
            [
                $this->getMockTransactionDocument(['document' => 1]),
                'document 3',
                $this->getMockTransactionDocument(['document' => 2]),
            ],
            'my_custom_id',
            'success_url',
            [
                $this->getMockTransactionSigners(['signer' => 1]),
                'signer 3',
                $this->getMockTransactionSigners(['signer' => 2]),
            ],
            [
                TestedTransactionRequest::KEY_OPTIONAL_IDENTIFICATION_TYPE  => 'identification_type',
                TestedTransactionRequest::KEY_OPTIONAL_LANGUAGE             => 'specific language',
                TestedTransactionRequest::KEY_FINAL_DOC_SENT                => true,
                TestedTransactionRequest::KEY_FINAL_DOC_REQUESTER_SENT      => true,
            ]

        );
        $this
            ->array($request->getArrayCopy())->isEqualTo(
            [
                'customId' => 'my_custom_id',
                'successURL' => 'success_url',
                'signers'   => [
                    ['signer' => 1],
                    ['signer' => 2],
                ],
                'documents' => [
                    ['document' => 1],
                    ['document' => 2],
                ],
                TestedTransactionRequest::KEY_OPTIONAL_IDENTIFICATION_TYPE  => 'identification_type',
                TestedTransactionRequest::KEY_OPTIONAL_LANGUAGE             => 'specific language',
                TestedTransactionRequest::KEY_FINAL_DOC_SENT                => true,
                TestedTransactionRequest::KEY_FINAL_DOC_REQUESTER_SENT      => true,
            ]
            )
        ;

        $request->setPrefix('prefix');

        $this
            ->array($request->getArrayCopy())->isEqualTo(
                [
                    'customId' => 'prefixmy_custom_id',
                    'successURL' => 'success_url',
                    'signers'   => [
                        ['signer' => 1],
                        ['signer' => 2],
                    ],
                    'documents' => [
                        ['document' => 1],
                        ['document' => 2],
                    ],
                    TestedTransactionRequest::KEY_OPTIONAL_IDENTIFICATION_TYPE  => 'identification_type',
                    TestedTransactionRequest::KEY_OPTIONAL_LANGUAGE             => 'specific language',
                    TestedTransactionRequest::KEY_FINAL_DOC_SENT                => true,
                    TestedTransactionRequest::KEY_FINAL_DOC_REQUESTER_SENT      => true,
                ]
            )
            ;
    }

    public function testOptionalDefaultValue()
    {
        $request = new TestedTransactionRequest(
            [
                $this->getMockTransactionDocument(['document' => 1]),
                'document 3',
                $this->getMockTransactionDocument(['document' => 2]),
            ],
            'my_custom_id',
            'success_url',
            [
                $this->getMockTransactionSigners(['signer' => 1]),
                'signer 3',
                $this->getMockTransactionSigners(['signer' => 2]),
            ]
        );
        $this
            ->array($request->getArrayCopy())->isEqualTo(
                [
                    'customId' => 'my_custom_id',
                    'successURL' => 'success_url',
                    'signers'   => [
                        ['signer' => 1],
                        ['signer' => 2],
                    ],
                    'documents' => [
                        ['document' => 1],
                        ['document' => 2],
                    ],
                    TestedTransactionRequest::KEY_OPTIONAL_IDENTIFICATION_TYPE  => 'none',
                    TestedTransactionRequest::KEY_OPTIONAL_LANGUAGE             => 'en',
                    TestedTransactionRequest::KEY_FINAL_DOC_SENT                => false,
                    TestedTransactionRequest::KEY_FINAL_DOC_REQUESTER_SENT      => false,
                ]
            )
        ;
    }

    protected function getMockTransactionDocument($get_array_data_value = [])
    {
        $return = new \mock\Wizacha\UniversignBundle\Document\TransactionDocument([], 0, 'ArrayIterator');
        $return->getMockController()->getArrayCopy = $get_array_data_value;
        return $return;
    }

    protected function getMockTransactionSigners($get_array_data_value = [])
    {
        $return = new \mock\Wizacha\UniversignBundle\Signer\TransactionSigner([], 0, 'ArrayIterator');
        $return->getMockController()->getArrayCopy = $get_array_data_value;
        return $return;
    }

}
