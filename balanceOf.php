<?php

require 'vendor/autoload.php';

use Web3\Contract;

$contractAddress = '0x085D15DB9c7Cd3Df188422f88Ec41ec573D691b9';

$abi = '[{"inputs":[{"internalType":"address","name":"account","type":"address"}],"name":"balanceOf","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"}]';

$contract = new Contract('https://bsc-dataseed.binance.org', $abi);

$contractInstance = $contract->at($contractAddress);

// Address of holder who wants to know token balance
$holder = '0x085D15DB9c7Cd3Df188422f88Ec41ec573D691b9';

$contractInstance->call('balanceOf', $holder, function ($err, $version) {
    if ($err !== null) {
        // Something went wrong
        return;
    }
    if (isset($version)) {
        echo $version[0];
    }
});