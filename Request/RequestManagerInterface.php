<?php
/**
 * This file is part of the WizachaUniversign bundle.
 *
 * (c) Wizacha <dev-team@wizacha.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Wizacha\UniversignBundle\Request;

use Wizacha\UniversignBundle\Core\CoreSendObjectInterface;
use Wizacha\UniversignBundle\Transaction\TransactionResponse;
use Wizacha\UniversignBundle\Transaction\TransactionInfo;
use Wizacha\UniversignBundle\Document\DocumentInterface;

interface RequestManagerInterface
{
    /**
     * @param CoreSendObjectInterface $transactionRequest
     * @return TransactionResponse
     */
    public function requestTransaction(CoreSendObjectInterface $transaction_request);

    /**
     * @param string $custom_id
     * @return TransactionInfo
     */
    public function getTransactionInfoByCustomId($custom_id);

    /**
     * @param string $custom_id
     * @return DocumentInterface
     */
    public function getDocumentsByCustomId($custom_id);

}