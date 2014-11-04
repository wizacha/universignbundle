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
use Wizacha\UniversignBundle\Certificate\CertificateInfo;
use Wizacha\UniversignBundle\Core\BaseReturnObject;

/**
 * Class SignerInfo
 * Describe the status of a signer. This class is used
 * as a return value only, and will never be instanciated by users
 * @package Wizacha\UniversignBundle\Signer
 */
class SignerInfo extends BaseReturnObject
{
    /**
     * The signer has not yet been invited to sign. Others signers must sign prior this user.
     */
    const STATUS_WAITING                = 'waiting';

    /**
     * The signer has been invited to sign, but has not tried yet.
     */
    const STATUS_READY                  = 'ready';

    /**
     * The signer has accessed the signature service.
     */
    const STATUS_ACCESSED               = 'accessed';

    /**
     * The signer agreed to sign and has been sent an OTP
     */
    const STATUS_CODE_SENT              = 'code-sent';

    /**
     * The signer has successfully signed
     */
    const STATUS_SIGNED                 = 'signed';

    /**
     * The signer has successfully signed and is pending RA validation.
     */
    const STATUS_PENDING_VALIDATION     = 'pending-validation';

    /**
     * The signer refused to sign, or one of the previous signers
     * canceled or failed its signature
     */
    const STATUS_CANCELED               = 'canceled';

    /**
     * An error occured dureing the signature. In this case, error is set
     */
    const STATUS_FAILED                 = 'failed';

    /**
     * @return null|string
     */
    public function getStatus()
    {
        return $this->getField('status');
    }

    /**
     * The error message in case of failure
     * @return null|string
     */
    public function getError()
    {
        return $this->getField('error');
    }

    /**
     * A bean containing information about the certificate the
     * signer used (or attempt to) to sign. If the signer has not
     * signed yet or in some cases if an error occurs during the
     * signature, an empty struct will be set for his certificate.
     * @return CertificateInfo
     */
    public function getCertificateInfo()
    {
        $raw_data = $this->getField('certificateInfo');
        if (!is_array($raw_data)) {
            $raw_data = [];
        }
        return new CertificateInfo($raw_data);
    }

    /**
     * The url of the signature page
     * @return null|string
     */
    public function getURL()
    {
        return $this->getField('url');
    }
}