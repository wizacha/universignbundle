<?php
/**
 * This file is part of the WizachaUniversign bundle.
 *
 * (c) Wizacha <dev-team@wizacha.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Wizacha\UniversignBundle\Certificate;
use Wizacha\UniversignBundle\Core\BaseReturnObject;

/**
 * Class CertificateInfo
 * The certificateInfo struct contains informations about
 * a certificate. This structure is used as a return
 * value only, and will never be instanciated by users
 * @package Wizacha\UniversignBundle\Certificate
 */
class CertificateInfo extends BaseReturnObject
{

    /**
     * The certificate subject DN
     *
     * @return null|string
     */
    public function getSubject()
    {
        return $this->getField('subject');
    }

    /**
     * The certificate issuer DN
     *
     * @return null|string
     */
    public function getIssuer()
    {
        return $this->getField('issuer');
    }

    /**
     * The certificate serial number
     *
     * @return null|string
     */
    public function getSerial()
    {
        return $this->getField('serial');
    }
}