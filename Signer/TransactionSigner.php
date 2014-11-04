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

use Wizacha\UniversignBundle\Core\CoreSendObjectInterface;

/**
 * Class TransactionSigner
 * A transactionSigner describes and contains options for a
 * document signer.
 * @package Wizacha\UniversignBundle\Signer
 */
class TransactionSigner implements CoreSendObjectInterface
{
    /**
     * @var string
     */
    protected $firstname        = '';

    /**
     * @var string
     */
    protected $lastname         = '';

    /**
     * @var string
     */
    protected $email_address    = '';

    /**
     * @var string
     */
    protected $organization     = '';

    /**
     * Expect international format.
     * By example, in France 33XXXXXXXXX 
     * @var string
     */
    protected $phone_num        = '';

    /**
     * @param string $firstname
     * @param string $lastname
     * @param string $email_address
     * @param string $organization
     * @param string $phone_num
     */
    public function __construct($firstname = '', $lastname = '', $email_address = '', $organization = '', $phone_num = '', $birthdate = '')
    {
        $this->firstname        = $firstname;
        $this->lastname         = $lastname;
        $this->email_address    = $email_address;
        $this->organization     = $organization;
        $this->phone_num        = $phone_num;
    }

    /**
     * @inheritdoc
     */
    public function getArrayData()
    {
        return [
            'firstname'     => $this->firstname,
            'lastname'      => $this->lastname,
            'emailAddress'  => $this->email_address,
            'organization'  => $this->organization,
            'phoneNum'      => $this->phone_num,
        ];
    }
}