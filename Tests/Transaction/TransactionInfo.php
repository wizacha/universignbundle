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
use Wizacha\UniversignBundle\Signer\SignerInfo;
use Wizacha\UniversignBundle\Transaction\TransactionInfo as TestedTransactionInfo;


class TransactionInfo extends atoum
{
    public function testConstructor()
    {
        $signer1 = new SignerInfo(['status' => 's1', 'url' => 'url1']);
        $signer2 = new SignerInfo(['status' => 's2', 'url' => 'url2']);
        $datas = [
            'status'        => 'status_value',
            'currentSigner' => 1,
            'creationDate'  => '14-12-1985',
            'description'   => 'description',
            'signerInfos'   => [
                $signer1->getArrayCopy(),
                $signer2->getArrayCopy(),
            ],
        ];

        $transaction = new TestedTransactionInfo($datas);
        $signerInfos = $transaction->getSignerInfos();

        $this
            ->string($transaction->getStatus())->isEqualTo('status_value')
            ->integer($transaction->getCurrentSigner())->isEqualTo(1)
            ->string($transaction->getCreationDate())->isEqualTo('14-12-1985')
            ->string($transaction->getDescription())->isEqualTo('description')
            ->array($signerInfos)->hasSize(2)
            ->object($signerInfos[0])->isEqualTo($signer1)
            ->object($signerInfos[1])->isEqualTo($signer2)
        ;
    }

    public function testConstructorWithoutData()
    {
        $signer = new TestedTransactionInfo([]);

        $this
            ->variable($signer->getStatus())->isNull()
            ->variable($signer->getCurrentSigner())->isNull()
            ->variable($signer->getCreationDate())->isNull()
            ->variable($signer->getDescription())->isNull()
            ->array($signer->getSignerInfos())->hasSize(0)
        ;
    }


}