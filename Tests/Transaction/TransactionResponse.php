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
use Wizacha\UniversignBundle\Transaction\TransactionResponse as TestedTransactionResponse;


class TransactionResponse extends atoum
{
    public function testConstructor()
    {
        $datas = [
            'url'   => 'transaction_response_url',
            'id'    => 'universign_id',
        ];

        $transaction = new TestedTransactionResponse($datas);
        $this
            ->string($transaction->getUrl())->isEqualTo('transaction_response_url')
            ->string($transaction->getId())->isEqualTo('universign_id')
        ;
    }

    public function testConstructorWithoutData()
    {
        $signer = new TestedTransactionResponse([]);

        $this
            ->variable($signer->getUrl())->isNull()
            ->variable($signer->getId())->isNull()
        ;
    }


}