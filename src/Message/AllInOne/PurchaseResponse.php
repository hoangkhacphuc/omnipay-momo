<?php
/**
 * @link https://github.com/phpviet/omnipay-momo
 * @copyright (c) PHP Viet
 * @license [MIT](http://www.opensource.org/licenses/MIT)
 */

namespace Omnipay\MoMo\Message\AllInOne;

use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * @author Vuong Minh <vuongxuongminh@gmail.com>
 * @since 1.0.0
 */
class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * {@inheritdoc}
     */
    public function isRedirect(): bool
    {
        return $this->isSuccessful();
    }

    /**
     * {@inheritdoc}
     */
    public function getRedirectUrl(): string
    {
        return $this->data['payUrl'];
    }

    /**
     * Trả về qr code image url dành cho thanh toán trực tiếp không cần chuyển sang MoMo.
     *
     * @return string
     */
    public function getQrCodeUrl(): string
    {
        return $this->data['qrCodeUrl'];
    }

    /**
     * Trả về link mở MoMo app cho khách hàng thanh toán.
     *
     * @return string
     */
    public function getDeepLink(): string
    {
        return $this->data['deeplink'];
    }

    /**
     * Trả về link mở màn hình xác nhận thanh toán của MoMo. Khi web của bạn nằm trong MoMo app.
     *
     * @return string
     */
    public function getDeepLinkWebInApp(): string
    {
        return $this->data['deeplinkWebInApp'];
    }
}