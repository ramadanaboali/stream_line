<?php

namespace App\Services;

class ArbPg
{
    public const ARB_HOSTED_ENDPOINT_TEST = 'https://securepayments.alrajhibank.com.sa/pg/payment/hosted.htm';
    public const ARB_HOSTED_ENDPOINT_PROD = 'https://digitalpayments.alrajhibank.com.sa/pg/payment/hosted.htm';

    public const ARB_MERCHANT_HOSTED_ENDPOINT_TEST = 'https://securepayments.alrajhibank.com.sa/pg/payment/tranportal.htm';
    public const ARB_MERCHANT_HOSTED_ENDPOINT_PROD = 'https://digitalpayments.alrajhibank.com.sa/pg/payment/tranportal.htm';

    public const ARB_PAYMENT_ENDPOINT_TESTING = 'https://securepayments.alrajhibank.com.sa/pg/paymentpage.htm?PaymentID=';
    public const ARB_PAYMENT_ENDPOINT_PROD = 'https://digitalpayments.alrajhibank.com.sa/pg/paymentpage.htm?PaymentID=';

    public const ARB_SUCCESS_STATUS = 'CAPTURED';
    public $Tranportal_ID ;
    public $Tranportal_Password ;
    public $resource_key ;
    public $order_id ;
    public $amount ;

    public function __construct($order_id, $amount)
    {
        $this->Tranportal_ID = config('banck.Tranportal_ID');
        $this->Tranportal_Password = config('banck.Tranportal_Password');
        $this->resource_key = config('banck.resource_key');
        $this->order_id = $order_id;
        $this->amount = $amount;
    }

    public function getmerchanthostedPaymentid($card_number, $expiry_month, $expiry_year, $cvv, $card_holder, $amount, $trackId)
    {
        $data = [
            "id" => $this->Tranportal_ID,
            "password" => $this->Tranportal_Password,
            "expYear" => $expiry_year,
            "expMonth" => $expiry_month,
            "member" => $card_holder,
            "cvv2" => $cvv,
            "cardNo" => str_replace('-', '', $card_number),
            "cardType" => "C",
            "action" => "1",
            "currencyCode" => "682",
            "errorURL" => route('errorURL'),
            "responseURL" => route('successURL'),
            "trackId" => $trackId,
            "amt" => $amount,
            "udf1" => $trackId,
        ];
        $data = json_encode($data, JSON_UNESCAPED_SLASHES);

        $wrappedData = $this->wrapData($data);

        $encData = [
            "id" => $this->Tranportal_ID,
            "trandata" => $this->encrypt($wrappedData, $this->resource_key),
            "errorURL" => route('errorURL'),
            "responseURL" => route('successURL'),
        ];

        $wrappedData = $this->wrapData(json_encode($encData, JSON_UNESCAPED_SLASHES));

        $curl = curl_init();
        $CURLOPT_URL=app()->isProduction() ? self::ARB_MERCHANT_HOSTED_ENDPOINT_PROD : self::ARB_MERCHANT_HOSTED_ENDPOINT_TEST;
        curl_setopt_array($curl, array(
            //in Production use Production End Point
            CURLOPT_URL => $CURLOPT_URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $wrappedData,

            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Accept-Language: application/json',
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response_data = json_decode($response, true)[0];
        if ($response_data["status"] == "1") {
            $url = "https:" . explode(":", $response_data["result"])[2];
            return $url;
        } else {


            return $response_data["errorText"];
        }
    }

    public function getPaymentId()
    {

        $plainData = $this->getRequestData();

        $wrappedData = $this->wrapData($plainData);

        $encData = [
            "id" => $this->Tranportal_ID,
            "trandata" => $this->encrypt($wrappedData, $this->resource_key),
            "errorURL" => route('errorURL'),
            "responseURL" => route('successURL'),
            "udf1" => $this->order_id,

        ];

        $wrappedData = $this->wrapData(json_encode($encData, JSON_UNESCAPED_SLASHES));

        $curl = curl_init();

        curl_setopt_array($curl, array(
            //in Production use Production End Point
            CURLOPT_URL => self::ARB_HOSTED_ENDPOINT_TEST,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $wrappedData,

            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Accept-Language: application/json',
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        // parse response and get id
        $data = json_decode($response, true)[0];
        if ($data["status"] == "1") {
            $id = explode(":", $data["result"])[0];
            $url = self::ARB_PAYMENT_ENDPOINT_TESTING . $id; //in Production use Production Payment End Point
            return $url;
        } else {
            // handle error either refresh on contact merchant
            return $data;
        }
    }


    public function getResult($trandata)
    {

        $decrypted = $this->decrypt($trandata, $this->resource_key);
        $raw = urldecode($decrypted);
        $dataArr = json_decode($raw, true);
        var_dump($dataArr);
        $paymentStatus = $dataArr[0]["result"];

        if (isset($paymentStatus) && $paymentStatus === self::ARB_SUCCESS_STATUS) {
            return "success";
        } else {
            return "rejected";
        }
    }

    private function getRequestData()
    {


$trackId = (string)rand(1, 1000000);


        $data = [
            "id" => $this->Tranportal_ID,
            "password" => $this->Tranportal_Password,
            "action" => "1",
            "currencyCode" => "682",
            "errorURL" => route('errorURL'),
            "responseURL" => route('successURL'),
            "trackId" => $trackId,
            "amt" => $this->amount,
            "udf1" => $this->order_id
        ];

        $data = json_encode($data, JSON_UNESCAPED_SLASHES);
        return $data;
    }

    private function wrapData($data)
    {
        $data = <<<EOT
        [$data]
        EOT;
        return $data;
    }

    public function encrypt($str, $key)
    {
        $blocksize = openssl_cipher_iv_length("AES-256-CBC");
        $pad = $blocksize - (strlen($str) % $blocksize);
        $str = $str . str_repeat(chr($pad), $pad);
        $encrypted = openssl_encrypt($str, "AES-256-CBC", $key, OPENSSL_ZERO_PADDING, "PGKEYENCDECIVSPC");
        $encrypted = base64_decode($encrypted);
        $encrypted = unpack('C*', ($encrypted));
        $chars = array_map("chr", $encrypted);
        $bin = join($chars);
        $encrypted = bin2hex($bin);
        $encrypted = urlencode($encrypted);
        return $encrypted;
    }

    public function decrypt($code, $key)
    {
        $string = hex2bin(trim($code));
        $code = unpack('C*', $string);
        $chars = array_map("chr", $code);
        $code = join($chars);
        $code = base64_encode($code);
        $decrypted = openssl_decrypt($code, "AES-256-CBC", $key, OPENSSL_ZERO_PADDING, "PGKEYENCDECIVSPC");
        $pad = ord($decrypted[strlen($decrypted) - 1]);
        if ($pad > strlen($decrypted)) {
            return false;
        }
        if (strspn($decrypted, chr($pad), strlen($decrypted) - $pad) != $pad) {
            return false;
        }
        return urldecode(substr($decrypted, 0, -1 * $pad));
    }
}
