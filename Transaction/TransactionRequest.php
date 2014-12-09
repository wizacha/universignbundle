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

use Wizacha\UniversignBundle\Document\TransactionDocument;
use Wizacha\UniversignBundle\Signer\SignerUserInterface;
use Wizacha\UniversignBundle\Signer\TransactionSigner;

/**
 * Class TransactionRequest
 * The TransactionRequest data structure contains informations and options for a
 * Signature transaction creation.
 * @package Wizacha\UniversignBundle\Transaction
 */
class TransactionRequest extends \ArrayObject
{
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

    protected $prefix               = '';

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
        $documents = array_filter($documents, function ($document) {return $document instanceof TransactionDocument;});
        if(empty($documents)) {
            throw new \Exception('TransactionRequest require at least one document');
        }

        $signers = array_filter($signers, function ($signer) {return $signer instanceof TransactionSigner;});
        if(empty($signers)) {
            throw new \Exception('TransactionRequest require at least one signer');
        }

        parent::__construct(
            [
                'customId'              => $custom_id,
                'successURL'            => $successURL,
                'documents'             => $documents,
                'signers'               => $signers,
                'identificationType'    => $identification_type,
                'language'              => $language,

            ]
        );
    }

    /**
     * @param string $prefix
     */
    public function setPrefix($prefix)
    {
        $this->prefix = strval($prefix);
    }

    public function getPrefix()
    {
        return $this->prefix;
    }


    /**
     * @inheritdoc
     */
    public function getArrayCopy()
    {
        $signers  = [];
        $documents =  [];

        foreach ($this['signers'] as $signer) {
            $signers[] = $signer->getArrayCopy();
        }

        foreach ($this['documents'] as $document) {
            $documents[] = $document->getArrayCopy();
        }
        $datas = parent::getArrayCopy();
        $datas['customId'] = $this->prefix . $datas['customId'];

        return array_merge($datas, [
                'documents' => $documents,
                'signers'   => $signers
            ]);
    }
}
