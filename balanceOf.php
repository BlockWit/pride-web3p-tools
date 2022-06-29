<?php

require 'vendor/autoload.php';

use PHP\Math\BigInteger\BigInteger;

//
//use Web3\Contract;
//
//$contractAddress = '0xe81F49f63F127A3289A8cffc70D6943E36effD3f';
//
//$abi = '[{"inputs":[{"internalType":"address","name":"account","type":"address"}],"name":"getPurchaseHistory","outputs":[{"components":[{"internalType":"uint256","name":"tokenId","type":"uint256"},{"internalType":"uint256","name":"price","type":"uint256"},{"internalType":"enum INFTMarket.Currency","name":"currency","type":"uint8"}],"internalType":"struct INFTMarket.Purchase[]","name":"","type":"tuple[]"}],"stateMutability":"view","type":"function"}]';
//
//$contract = new Contract('https://data-seed-prebsc-1-s1.binance.org:8545', $abi);
//
//$contractInstance = $contract->at($contractAddress);
//
//// Address of holder who wants to know token balance
//$holder = '0x0EDF5620d75EEf555F927cfd28679494733F2cCd';
//
//
//$contractInstance->call('getPurchaseHistory', $holder, function ($err, $response) {
//    if ($err !== null) {
//        // Something went wrong
//        return;
//    }
//    if (isset($response)) {
//        // Return balance
//        $balance = $response[0];
//        // Let's do something what you want with balance
//        echo $balance;
//    }
//});

//$single = "0x0000000000000000000000000000000000000000000000000000000000000020000000000000000000000000000000000000000000000000000000000000000100000000000000000000000000000000000000000000000000000000000002ad000000000000000000000000000000000000000000000000016345785d8a00000000000000000000000000000000000000000000000000000000000000000002";
$single = "0x0000000000000000000000000000000000000000000000000000000000000020000000000000000000000000000000000000000000000000000000000000000200000000000000000000000000000000000000000000000000000000000002ad000000000000000000000000000000000000000000000000016345785d8a0000000000000000000000000000000000000000000000000000000000000000000200000000000000000000000000000000000000000000000000000000000002af00000000000000000000000000000000000000000000000000000000000000010000000000000000000000000000000000000000000000000000000000000000";
$preparedSingle = substr($single, 2);
$singleSplited = str_split($preparedSingle , 64);
$sizeString = hexdec(trim($singleSplited[1], "00"));
$arrayOfTokens = [];
for($i = 0; $i < $sizeString; $i++) {
    $curValue = trim($singleSplited[$i*3 + 4], "00");
    $preparedCurValue = $curValue == 0 ? 'pride' : ($curValue == 1 ? 'erc20' : 'native');
    $once = [
        'tokenId' => new BigInteger(hexdec($singleSplited[$i*3 + 2])),
        'price' => new BigInteger(base_convert($singleSplited[$i*3 + 3], 16, 10)),
        'currency' => $preparedCurValue
    ];
    array_push($arrayOfTokens, $once);
};

print_r($arrayOfTokens);





