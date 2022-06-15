<?php

require 'vendor/autoload.php';

use Web3\Contract;

$contractAddress = '0x363189488bCD7B928DE7f954A131637Fac0fe4b0';

$abi = '[{"inputs":[{"internalType":"address","name":"account","type":"address"}],"name":"balanceOf","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"}]';

$contract = new Contract('https://data-seed-prebsc-1-s1.binance.org:8545', $abi);

$contractInstance = $contract->at($contractAddress);

// Address of holder who wants to know token balance
$holder = '0x0edf5620d75eef555f927cfd28679494733f2ccd';

$contractInstance->call('balanceOf', $holder, function ($err, $response) {
    if ($err !== null) {
        // Something went wrong
        return;
    }
    if (isset($response)) {
        // Return balance
        $balance = $response[0];
        // Let's do something what you want with balance
        echo $balance;
    }
});