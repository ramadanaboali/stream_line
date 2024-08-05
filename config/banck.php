<?php

return [
    'Tranportal_ID' => env('TRANSPORTAL_ID','gZz0c24eIBI2x2U'),
    'Tranportal_Password' => env('TRANSPORTAL_PASSWORD','Euk82NV5#8nv!T$'),
    'resource_key' => env('RESOURCE_KEY','42173930744242173930744242173930'),
    'ARB_HOSTED_ENDPOINT_TEST'=> env('ARB_HOSTED_ENDPOINT_TEST','https://securepayments.alrajhibank.com.sa/pg/payment/hosted.htm'),
    'ARB_HOSTED_ENDPOINT_PROD'=> env('ARB_HOSTED_ENDPOINT_PROD','https://digitalpayments.alrajhibank.com.sa/pg/payment/hosted.htm'),
    'ARB_MERCHANT_HOSTED_ENDPOINT_TEST'=> env('ARB_MERCHANT_HOSTED_ENDPOINT_TEST','https://securepayments.alrajhibank.com.sa/pg/payment/tranportal.htm'),
    'ARB_MERCHANT_HOSTED_ENDPOINT_PROD'=> env('ARB_MERCHANT_HOSTED_ENDPOINT_PROD','https://digitalpayments.alrajhibank.com.sa/pg/payment/tranportal.htm'),
    'ARB_PAYMENT_ENDPOINT_TESTING'=> env('ARB_PAYMENT_ENDPOINT_TESTING','https://securepayments.alrajhibank.com.sa/pg/paymentpage.htm?PaymentID='),
    'ARB_PAYMENT_ENDPOINT_PROD'=> env('ARB_PAYMENT_ENDPOINT_PROD','https://digitalpayments.alrajhibank.com.sa/pg/paymentpage.htm?PaymentID='),
    'ARB_SUCCESS_STATUS'=> env('ARB_SUCCESS_STATUS','CAPTURED'),
];
