<?php
/**
 * Server module for HiPanel.
 *
 * @link      https://github.com/hiqdev/hipanel-module-server
 * @package   hipanel-module-server
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\certificate\cart;

use hipanel\modules\certificate\models\Certificate;
use hipanel\modules\certificate\models\CertificateType;
use hipanel\modules\finance\models\CertificateResource;
use Yii;


/**
 * Class ServerRenewProduct.
 */
class CertificateRenewProduct extends AbstractCertificateProduct
{
    /** {@inheritdoc} */
    protected $_purchaseModel = CertificateRenewPurchase::class;

    /** {@inheritdoc} */
    protected $_calculationModel = RenewCalculation::class;

    /** {@inheritdoc} */
    protected $_operation = CertificateResource::TYPE_CERT_RENEWAL;

    /**
     * @var Certificate
     */
    protected $_certificate;

    /**
     * @var date
     */
    public $expires;

    /** {@inheritdoc} */
    public static function primaryKey()
    {
        return ['model_id'];
    }

    public function getCertificate()
    {
        return $this->_certificate;
    }

    /** {@inheritdoc} */
    protected function ensureRelatedData()
    {
        $this->_certificate = Certificate::findOne(['id' => $this->model_id]);
        $this->_model = $this->_certificate->getCertificateType();
        $this->name = $this->_model->name;
        $this->description = Yii::t('hipanel:certificate', 'Renewal');
        $this->expires = $this->_certificate->expires;
    }

    /** {@inheritdoc} */
    public function getId()
    {
        return hash('crc32b', implode('_', ['certificate', 'renew', $this->_model->id]));
    }

    /** {@inheritdoc} */
    public function getCalculationModel($options = [])
    {
        return parent::getCalculationModel(array_merge([
            'type' => $this->_operation,
            'name' => $this->name,
            'product_id' => $this->_model->id,
            'expires' => $this->expires,
        ], $options));
    }

    /** {@inheritdoc} */
    public function getPurchaseModel($options = [])
    {
        $this->ensureRelatedData(); // To get fresh domain expiration date
        return parent::getPurchaseModel(array_merge([
            'id' => $this->_certificate->id,
            'product_id' => $this->_certificate->product_id,
            'expires' => $this->_certificate->expires,
        ], $options));
    }

    /** {@inheritdoc} */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['model_id', 'product_id'], 'integer'],
            [['expires'], 'date'],
            [['name'], 'required'],
            [['expires'], 'requoired'],
        ]);
    }
}
