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
use Wizacha\UniversignBundle\Transaction\TransactionRequest as TestedTransactionRequest;


class TransactionRequest extends atoum
{
    public function testGetArrayDataReturnCorrectData()
    {


        $request = new TestedTransactionRequest(
            [
                $this->getMockCoreSendObjectInterface(['document' => 1]),
                'document 3',
                $this->getMockCoreSendObjectInterface(['document' => 2]),
            ],
            'my_custom_id',
            'success_url',
            [
                $this->getMockCoreSendObjectInterface(['signer' => 1]),
                'signer 3',
                $this->getMockCoreSendObjectInterface(['signer' => 2]),
            ],
            'identification_type',
            'specific language'
        );
        $this
            ->array($request->getArrayData())->isEqualTo(
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
                'identificationType'    => 'identification_type',
                'language'              => 'specific language',
            ]
            )
        ;
    }

    protected function getMockCoreSendObjectInterface($get_array_data_value = [])
    {
        $return = new \mock\Wizacha\UniversignBundle\Core\CoreSendObjectInterface();
        $return->getMockController()->getArrayData = $get_array_data_value;
        return $return;
    }


}