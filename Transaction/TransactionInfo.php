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

use Wizacha\UniversignBundle\Core\BaseReturnObject;
use Wizacha\UniversignBundle\Signer\SignerInfo;

/**
 * Class TransactionInfo
 * The TransactionInfo data structure describes the status of a transaction. This
 * structure is used as a return value only, and will never be instanciated by users.
 * @package Wizacha\UniversignBundle\Transaction
 */
class TransactionInfo extends BaseReturnObject
{
    /**
     * Signers can connect and sign
     */
    const STATUS_READY      = 'ready';

    /**
     * The transaction has benn requested more than 7 days ago.
     * It will no  more be available to signers.
     */
    const STATUS_EXPIRED    = 'expired';

    /**
     * A signer has canceled the trnsaction. Signer will no more
     * be able to connect to the service.
     */
    const STATUS_CANCELED   = 'canceled';

    /**
     * An error occured during a signature. The signers won't be
     * able to connect to the service.
     */
    const STATUS_FAILED     = 'failed';

    /**
     * All signers have successfuly sign, the requester can retrieve
     * the documents.
     */
    const STATUS_COMPLETED  = 'completed';

    /**
     * The status of the transaction
     * @return null|string
     */
    public function getStatus()
    {
        return $this->getField('status');
    }

    /**
     * The index of current signer if the status of
     * transaction is ready or xho ended the transaction
     * for other status.
     * @return null|integer
     */
    public function getCurrentSigner()
    {
        return $this->getField('currentSigner');
    }

    /**
     * The creation date or last relaunch date of this transaction
     * @return null|string
     */
    public function getCreationDate()
    {
        return $this->getField('creationDate');
    }

    /**
     * The description of the transaction
     * @return null|string
     */
    public function getDescription()
    {
        return $this->getField('description');
    }

    /**
     * A list of bean containing information about the
     * signers and their progression in the signature
     * process
     * @return array list of SignerInfo
     */
    public function getSignerInfos()
    {
        $signer_infos = $this->getField('signerInfos');
        if (!is_array($signer_infos)) {
            $signer_infos = [];
        }
        array_filter($signer_infos, 'is_array');
        $return = [];
        foreach ($signer_infos as $signer_info ) {
            $return[] = new SignerInfo($signer_info);
        }
        return $return;
    }

}