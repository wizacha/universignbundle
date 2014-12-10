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

use Wizacha\UniversignBundle\Document\TransactionDocument;
use Wizacha\UniversignBundle\Transaction\TransactionRequest;
use Wizacha\UniversignBundle\Transaction\TransactionResponse;
use Wizacha\UniversignBundle\Transaction\TransactionInfo;;

class RequestManagerFaker implements RequestManagerInterface
{

    /**
     * @inheritdoc
     */
    public function requestTransaction(TransactionRequest $transaction_request)
    {
        $params = $transaction_request->getArrayCopy();
        return new TransactionResponse(
            [
                'url' => $params['successURL'],
                'id'  => uniqid(),
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function getTransactionInfoByCustomId($custom_id)
    {
        return new TransactionInfo([
            'status' => TransactionInfo::STATUS_COMPLETED,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getDocumentsByCustomId($id)
    {
        $document = new TransactionDocument();
        $document->setContent($id.'content');
        $document->setName($id.'.doc');
        return [$document];
    }

    /**
     * @inheritdoc
     */
    public function getTransactionInfo($id)
    {
        return new TransactionInfo([
            'status' => TransactionInfo::STATUS_COMPLETED,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getDocuments($custom_id)
    {
        $document = new TransactionDocument();
        $document->setContent($custom_id.'content');
        $document->setName($custom_id.'.doc');
        return [$document];
    }
}