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
use Wizacha\UniversignBundle\Signer\TransactionSigner as TestedSigner;


class TransactionSigner extends atoum
{
    public function testConstructor()
    {
        $firstname = 'firstname';
        $lastname = 'lastname';
        $organization = '';
        $email = 'email@example.com';
        $phone = '33123456789';
        $signer = new TestedSigner($firstname, $lastname, $email, $organization, $phone);
        $this
            ->array($signer->getArrayCopy())->isEqualTo(
                [
                    'firstname'     => $firstname,
                    'lastname'      => $lastname,
                    'emailAddress'  => $email,
                    'organization'  => $organization,
                    'phoneNum'      => $phone,
                ]
            )
        ;
    }
}