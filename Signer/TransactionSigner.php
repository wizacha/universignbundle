<?php
/**
 * This file is part of the WizachaUniversign bundle.
 *
 * (c) Wizacha <dev-team@wizacha.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Wizacha\UniversignBundle\Signer;

/**
 * Class TransactionSigner
 * A transactionSigner describes and contains options for a
 * document signer.
 * @package Wizacha\UniversignBundle\Signer
 */
class TransactionSigner extends \ArrayObject
{
    /**
     * @param string $firstname
     * @param string $lastname
     * @param string $email_address
     * @param string $organization
     * @param string $phone_num
     */
    public function __construct($firstname = '', $lastname = '', $email_address = '', $organization = '', $phone_num = '')
    {
        parent::__construct(
            [
                'firstname'     => $firstname,
                'lastname'      => $lastname,
                'emailAddress'  => $email_address,
                'organization'  => $organization,
                'phoneNum'      => $phone_num,
            ]
        );
    }

}