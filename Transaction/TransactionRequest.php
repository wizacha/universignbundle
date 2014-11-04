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

use Wizacha\UniversignBundle\Core\CoreSendObjectInterface;
use Wizacha\UniversignBundle\Document\DocumentInterface;
use Wizacha\UniversignBundle\Signer\SignerUserInterface;

/**
 * Class TransactionRequest
 * The TransactionRequest data structure contains informations and options for a
 * Signature transaction creation.
 * @package Wizacha\UniversignBundle\Transaction
 */
class TransactionRequest implements CoreSendObjectInterface
{
    /**
     * @var array list of DocumentInterface
     */
    protected $documents            = [];

    /**
     * @var string
     */
    protected $custom_id            = '';

    /**
     * @var string
     */
    protected $successURL           = '';

    /**
     * @var array list of SignerUserInterface
     */
    protected $signers              = [];

    /**
     * This option indicate wich authentification type will be used
     * when a signer will attempt to sign
     * @var string (none|email|sms)
     */
    protected $identification_type  = '';

    /**
     * The interface language for this transaction
     * @var string (en|fr)
     */
    protected $language             = '';

    /**
     * @param array $documents
     * @param $custom_id
     * @param $successURL
     * @param array $signers
     * @param string $identification_type
     * @param string $language
     */
    public function __construct(array $documents, $custom_id, $successURL, array $signers, $identification_type = 'none', $language = 'en')
    {
        $documents = array_filter($documents, function ($document) {return $document instanceof CoreSendObjectInterface;});
        if(empty($documents)) {
            throw new \Exception('TransactionRequest require at least one document');
        }

        $signers = array_filter($signers, function ($signer) {return $signer instanceof CoreSendObjectInterface;});
        if(empty($signers)) {
            throw new \Exception('TransactionRequest require at least one signer');
        }

        $this->documents            = $documents;
        $this->custom_id            = $custom_id;
        $this->successURL           = $successURL;
        $this->signers              = $signers;
        $this->identification_type  = $identification_type;
        $this->language             = $language;
    }

    /**
     * @inheritdoc
     */
    public function getArrayData()
    {
        $signers  = [];
        $documents =  [];

        foreach ($this->signers as $signer) {
            $signers[] = $signer->getArrayData();
        }

        foreach ($this->documents as $document) {
            $documents[] = $document->getArrayData();
        }

        return [
            'customId'              => $this->custom_id,
            'successURL'            => $this->successURL,
            'signers'               => $signers,
            'documents'             => $documents,
            'identificationType'    => $this->identification_type,
            'language'              => $this->language,
        ];
    }
}