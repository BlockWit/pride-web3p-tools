<?php

require 'vendor/autoload.php';

use Web3\Contract;
use Web3\Eth;
use Web3\Formatters\AddressFormatter;
use Web3\Providers\HttpProvider;
use Web3\RequestManagers\HttpRequestManager;
use Web3\Utils;
use Web3\Web3;
use PHP\Math\BigInteger\BigInteger;

$contractAddress = '0x24a14F9Aa908986EbBB858624B13d48c15510b33';

$abi = '[{"inputs":[{"internalType":"address","name":"account","type":"address"}],"name":"getPurchaseHistory","outputs":[{"components":[{"internalType":"uint256","name":"tokenId","type":"uint256"},{"internalType":"uint256","name":"price","type":"uint256"},{"internalType":"enumINFTMarket.Currency","name":"currency","type":"uint8"}],"internalType":"structINFTMarket.Purchase[]","name":"","type":"tuple[]"}],"stateMutability":"view","type":"function"}]';

$provider = new HttpProvider(new HttpRequestManager('https://data-seed-prebsc-1-s1.binance.org:8545', 5));
$eth = new Eth($provider);
$contract = new Contract($provider, $abi);

// Address of holder who wants to know token balance
$holder = '0x0EDF5620d75EEf555F927cfd28679494733F2cCd';

$web3 = new Web3($provider);
$contractInstance = $contract->at($contractAddress);

$transaction = [];
$ethabi = $contractInstance->getEthabi();
$function = $contractInstance->getFunctions()[0];
$params = [$holder];
$data = $ethabi->encodeParameters($function, $params);
//$functionSignature = $ethabi->encodeFunctionSignature("getPurchaseHistory");
$functionSignature = "0x21034444";
$transaction['to'] = AddressFormatter::format($contractAddress);
$transaction['data'] = $functionSignature . Utils::stripZero($data);
$eth = $web3->__get('eth');

$eth->call($transaction, "latest", function ($err, $transaction){
    $preparedSingle = substr($transaction, 2);
    $singleSplited = str_split($preparedSingle , 64);
    $sizeString = hexdec($singleSplited[1]);
    $arrayOfTokens = [];
    for($i = 0; $i < $sizeString; $i++) {
        $curValue = hexdec($singleSplited[$i*4 + 4]);
        $preparedCurValue = $curValue == 0 ? 'pride' : ($curValue == 1 ? 'erc20' : 'native');
        $once = [
            'tokenId' => new BigInteger(hexdec($singleSplited[$i*4 + 2])),
            'price' => new BigInteger(base_convert($singleSplited[$i*4 + 3], 16, 10)),
            'currency' => $preparedCurValue,
            'timestamp' => hexdec($singleSplited[$i*4 + 5])
        ];
        array_push($arrayOfTokens, $once);
    };

    // TODO: Place your code here. You should work with $arrayOfTokens
    print_r($arrayOfTokens);
});

