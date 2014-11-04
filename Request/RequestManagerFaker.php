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
use Wizacha\UniversignBundle\Document\DocumentSimple;

class RequestManagerFaker implements RequestManagerInterface
{

    /**
     * @inheritdoc
     */
    public function requestTransaction(CoreSendObjectInterface $transaction_request)
    {
        return $transaction_request->getArrayData()['successURL'];
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
    public function getDocumentsByCustomId($custom_id)
    {
        $document = new DocumentSimple();
        $document->setContent($custom_id.'content');
        $document->setName($custom_id.'.doc');
        return $document;
    }
}