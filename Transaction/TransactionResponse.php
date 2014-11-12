<?php
/**
 * This file is part of the WizachaUniversign bundle.
 *
 * (c) Wizacha <dev-team@wizacha.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Wizacha\UniversignBundle\Transaction;


/**
 * Class TransactionResponse
 * The TransactionResponse data structure is the response sent after a request
 * for a transaction. This structure is used as a return value only, and will never be
 * instanciated by users.
 * @package Wizacha\UniversignBundle\Transaction
 */
class TransactionResponse extends \ArrayObject
{

    /**
     * The URL to the web interface for the first signer
     * @return null|string
     */
    public function getUrl()
    {
        return @$this['url'];
    }

    /**
     * The transaction Id
     * @return null|string
     */
    public function getId()
    {
        return @$this['id'];
    }

}