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

use hipanel\base\ModelTrait;

/**
 * Class ServerRenewPurchase.
 */
class CertificateRenewPurchase extends AbstractCertificatePurchase
{
    use ModelTrait;

    /** {@inheritdoc} */
    public static function operation()
    {
        return 'Renew';
    }

    /** {@inheritdoc} */
    public function init()
    {
        parent::init();

        $this->name = $this->position->name;
        $this->amount = $this->position->getQuantity();
    }

    /**
     * @var string certificate expiration datetime
     */
    public $expires;

    /**
     * @var integer
     */
    public $id;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['name', 'expires'], 'safe'],
            [['expires', 'amount'], 'required'],
            [['product_id'], 'integer'],
        ]);
    }
}
