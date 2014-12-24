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
use Wizacha\UniversignBundle\Transaction\TransactionInfo;
use Wizacha\UniversignBundle\Transaction\TransactionRequest;
use Wizacha\UniversignBundle\Transaction\TransactionResponse;

class RequestManager implements RequestManagerInterface
{

    /**
     * @var null|\xmlrpcval
     */
    protected $client = null;

    protected $prefix = '';
    /**
     * @param \xmlrpc_client $client
     * @param string $prefix
     */
    public function __construct(\xmlrpc_client $client, $prefix = '')
    {
        $this->client = $client;
        $this->prefix = $prefix;

        //This value cannot be set via dependency injection :(
        global $xmlrpc_internalencoding;
        $xmlrpc_internalencoding = 'UTF-8';
    }

    /**
     * @inheritdoc
     */
    public function requestTransaction(TransactionRequest $transaction_request)
    {
        $transaction_request->setPrefix($this->prefix);
        $message = new \xmlrpcmsg(
            'requester.requestTransaction',
            [$this->convertParams($transaction_request->getArrayCopy(), 'transactionRequest')]
        );

        $response = $this->client->send($message);
        $this->handleErrors($response);
        return new TransactionResponse($this->convertXmlValue($response->val));
    }

    /**
     * @inheritdoc
     */
    public function getTransactionInfoByCustomId($custom_id)
    {
        $message = new \xmlrpcmsg(
            'requester.getTransactionInfoByCustomId',
            [new \xmlrpcval($this->prefix.$custom_id, 'string')]
        );
        $response = $this->client->send($message);
        $this->handleErrors($response);
        return new TransactionInfo($this->convertXmlValue($response->val));
    }

    /**
     * @inheritdoc
     */
    public function getDocumentsByCustomId($custom_id)
    {
        $message = new \xmlrpcmsg(
            'requester.getDocumentsByCustomId',
            [new \xmlrpcval($this->prefix.$custom_id), 'string']
        );
        $response = $this->client->send($message);
        $this->handleErrors($response);
        $return = [];
        foreach ($this->convertXmlValue($response->val) as $document_raw) {
            $return[] = new TransactionDocument($document_raw);
        }
        return $return;

    }

    /**
     * @inheritdoc
     */
    public function getTransactionInfo($id)
    {
        $message = new \xmlrpcmsg(
            'requester.getTransactionInfo',
            [new \xmlrpcval($id, 'string')]
        );
        $response = $this->client->send($message);
        $this->handleErrors($response);
        return new TransactionInfo($this->convertXmlValue($response->val));
    }

    /**
     * @inheritdoc
     */
    public function getDocuments($id)
    {
        $message = new \xmlrpcmsg(
            'requester.getDocuments',
            [new \xmlrpcval($id), 'string']
        );
        $response = $this->client->send($message);
        $this->handleErrors($response);
        $return = [];
        foreach ($this->convertXmlValue($response->val) as $document_raw) {
            $return[] = new TransactionDocument($document_raw);
        }
        return $return;

    }

    /**
     * @param \xmlrpcresp $response
     * @throws \Exception
     */
    public function handleErrors(\xmlrpcresp $response)
    {
        if ($response->errno) {
            throw new \Exception('Request has error n°'.$response->errno.' with message'.$response->errstr);
        }
    }

    public function convertXmlValue($value)
    {
        if ($value instanceof \xmlrpcval) {
            $value = $value->scalarval();
        }
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $value[$k] = $this->convertXmlValue($v);
            }
        }
        return $value;
    }

    protected function getParamType($param)
    {
        static $list = [
            'content'               => 'base64',
            'customId'              => 'string',
            'documents'             => 'array',
            'emailAddress'          => 'string',
            'firstname'             => 'string',
            TransactionRequest::KEY_OPTIONAL_IDENTIFICATION_TYPE    => 'string',
            TransactionRequest::KEY_OPTIONAL_LANGUAGE               => 'string',
            'lastname'              => 'string',
            'location'              => 'string',
            'name'                  => 'string',
            'organization'          => 'string',
            'phoneNum'              => 'string',
            'profile'               => 'string',
            'reason'                => 'string',
            'signatureFormat'       => 'string',
            'signers'               => 'array',
            'successURL'            => 'string',
            TransactionRequest::KEY_FINAL_DOC_REQUESTER_SENT        => 'boolean',
            TransactionRequest::KEY_FINAL_DOC_SENT                  => 'boolean',
        ];

        return isset($list[$param]) ? $list[$param] : 'struct';
    }

    protected function convertParams($params, $key)
    {
        if (!is_array($params)) {
            return new \xmlrpcval($params, $this->getParamType($key));
        }
        $return = [];
        foreach ($params as $param_name => $value) {
            $return[$param_name] = $this->convertParams($value, $param_name);
        }
        return new \xmlrpcval($return, $this->getParamType($key));
    }

}
