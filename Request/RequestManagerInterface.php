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

use Wizacha\UniversignBundle\Transaction\TransactionRequest;
use Wizacha\UniversignBundle\Transaction\TransactionResponse;
use Wizacha\UniversignBundle\Transaction\TransactionInfo;
use Wizacha\UniversignBundle\Document\TransactionDocument;

interface RequestManagerInterface
{
    /**
     * @param TransactionRequest $transactionRequest
     * @return TransactionResponse
     */
    public function requestTransaction(TransactionRequest $transaction_request);

    /**
     * @param string $custom_id
     * @return TransactionInfo
     */
    public function getTransactionInfoByCustomId($custom_id);

    /**
     * @param string $custom_id
     * @return array list TransactionDocument
     */
    public function getDocumentsByCustomId($custom_id);

    /**
     * @param string $id (universign transaction id)
     * @return array list TransactionDocument
     */
    public function getDocuments($id);


    /**
     * @param string $id (universign transaction id)
     * @return TransactionInfo
     */
    public function getTransactionInfo($id);

}