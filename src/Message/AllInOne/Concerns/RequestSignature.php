<?php
/**
 * @link https://github.com/phpviet/omnipay-momo
 * @copyright (c) PHP Viet
 * @license [MIT](http://www.opensource.org/licenses/MIT)
 */

namespace Omnipay\MoMo\Message\AllInOne\Concerns;

use InvalidArgumentException;
use Omnipay\MoMo\Support\Signature;

/**
 * @author Vuong Minh <vuongxuongminh@gmail.com>
 * @since 1.0.0
 * @mixin \Omnipay\Common\Message\AbstractRequest
 */
trait RequestSignature
{
    /**
     * Trả về chữ ký điện tử gửi đến MoMo dựa theo `$requestType` truyền vào.
     *
     * @param  string  $requestType
     * @return string
     */
    protected function generateSignature(string $requestType): string
    {
        $data = [];
        $signature = new Signature($this->getParameter('secretKey'));

        foreach ($this->getSignatureParameters($requestType) as $parameter) {
            $data[$parameter] = $this->getParameter($parameter);
        }

        return $signature->generate($data);
    }

    /**
     * Trả về danh sách param dùng để tạo chữ ký số theo `$requestType`.
     *
     * @param  string  $requestType
     * @return array
     */
    protected function getSignatureParameters(string $requestType): array
    {
        switch ($requestType) {
            case 'captureMoMoWallet':
                return [
                    'partnerCode', 'accessKey', 'requestId', 'amount', 'orderId', 'orderInfo', 'returnUrl', 'notifyUrl',
                    'extraData',
                ];
            case 'transactionStatus':
            case 'refundMoMoWallet':
            case 'refundStatus':
                return [
                    'partnerCode', 'accessKey', 'requestId', 'orderId', 'requestType',
                ];
            default:
                throw new InvalidArgumentException(sprintf('Request type: (%s) is not valid!', $requestType));
        }
    }
}