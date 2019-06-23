<?php
/**
 * @link https://github.com/phpviet/omnipay-momo
 * @copyright (c) PHP Viet
 * @license [MIT](http://www.opensource.org/licenses/MIT)
 */

namespace Omnipay\MoMo\Message\AllInOne\Concerns;

use Omnipay\MoMo\Support\Signature;
use Omnipay\Common\Exception\InvalidResponseException;

/**
 * @author Vuong Minh <vuongxuongminh@gmail.com>
 * @since 1.0.0
 */
trait ResponseSignatureValidation
{
    /**
     * @var array
     */
    protected $data;

    /**
     * Kiểm tra tính hợp lệ của dữ liệu do MoMo phản hồi.
     *
     * @param  string  $secretKey
     * @throws InvalidResponseException
     */
    protected function validateSignature(string $secretKey): void
    {
        $data = [];
        $signature = new Signature($secretKey);

        foreach ($this->getSignatureParameters($this->data['requestType']) as $param) {
            $data[$param] = $this->data[$param];
        }

        if (! $signature->validate($data, $this->data['signature'])) {

            throw new InvalidResponseException(sprintf('Data signature response from MoMo is invalid!'));
        }
    }

    /**
     * Trả về danh sách các param data đã dùng để tạo chữ ký dữ liệu theo requestType truyền vào.
     *
     * @param  string  $requestType
     * @return array
     */
    protected function getSignatureParameters(string $requestType): array
    {
        switch ($requestType) {
            case 'captureMoMoWallet':
                return [
                    'requestId', 'orderId', 'message', 'localMessage', 'payUrl', 'errorCode', 'requestType',
                ];
            case 'transactionStatus':
                return [
                    'partnerCode', 'accessKey', 'requestId', 'orderId', 'errorCode', 'transId', 'amount', 'message',
                    'localMessage', 'requestType', 'payType', 'extraData',
                ];
            case 'refundMoMoWallet':
                return [
                    'partnerCode', 'accessKey', 'requestId', 'orderId', 'errorCode', 'transId', 'message',
                    'localMessage', 'requestType',
                ];
            case 'refundStatus':
                return [
                    'partnerCode', 'accessKey', 'requestId', 'orderId', 'errorCode', 'transId', 'amount', 'message',
                    'localMessage', 'requestType',
                ];
            default:
                return [];
        }
    }
}