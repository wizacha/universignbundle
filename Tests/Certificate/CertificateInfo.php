<?php
/**
 * This file is part of the WizachaUniversign bundle.
 *
 * (c) Wizacha <dev-team@wizacha.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Wizacha\UniversignBundle\Certificate\tests\units;

use \atoum;
use Wizacha\UniversignBundle\Certificate\CertificateInfo as TestedCertificateInfo;

class CertificateInfo extends atoum
{
    public function testConstructor()
    {
        $datas = [
            'subject'   => 'subject_DN',
            'issuer'    => 'issuer_DN',
            'serial'    => 'serial_number',
        ];
        $signer = new TestedCertificateInfo($datas);

        $this
            ->string($signer->getSubject())->isEqualTo('subject_DN')
            ->string($signer->getIssuer())->isEqualTo('issuer_DN')
            ->string($signer->getSerial())->isEqualTo('serial_number')
        ;
    }

    public function testConstructorWithoutData()
    {
        $signer = new TestedCertificateInfo([]);

        $this
            ->variable($signer->getSubject())->isNull()
            ->variable($signer->getIssuer())->isNull()
            ->variable($signer->getSerial())->isNull()
        ;
    }


}