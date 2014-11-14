<?php
/**
 * This file is part of the WizachaUniversign bundle.
 *
 * (c) Wizacha <dev-team@wizacha.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Wizacha\UniversignBundle\Signer\tests\units;

use \atoum;
use Wizacha\UniversignBundle\Signer\SignerInfo as TestedSignerInfo;
use Wizacha\UniversignBundle\Certificate\CertificateInfo;

class SignerInfo extends atoum
{
    public function testConstructor()
    {
        $certificate_info_data = [
            'subject'   => 'subject_DN',
            'issuer'    => 'issuer_DN',
            'serial'    => 'serial_number',
        ];
        $data = [
            'status'            => 'status_code',
            'error'             => 'error_string',
            'url'               => 'sign_url',
            'certificateInfo'   => $certificate_info_data
        ];
        $certificate_info = new CertificateInfo($certificate_info_data);
        $signer = new TestedSignerInfo($data);
        $this
            ->string($signer->getStatus())->isEqualTo('status_code')
            ->string($signer->getError())->isEqualTo('error_string')
            ->string($signer->getUrl())->isEqualTo('sign_url')
            ->object($signer->getCertificateInfo())->isEqualTo($certificate_info)
        ;
    }

    public function testConstructorWithoutData()
    {
        $signer = new TestedSignerInfo();
        $this
            ->variable($signer->getStatus())->isNull()
            ->variable($signer->getError())->isNull()
            ->variable($signer->getUrl())->isNull()
            ->object($signer->getCertificateInfo())->isEqualTo(new CertificateInfo())
        ;
    }


}