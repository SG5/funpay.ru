<?php

function parseMessage($message) {

    if (preg_match('#41001\d{5,}#', $message, $account)) {
        $account = $account[0];
        $message = str_replace($account, '', $message);
    } else {
        throw new LogicException('Account not found');
    }

    if (preg_match('#\s[1-9]\d*(?:[\.,]\d+)?р#ui', $message, $amount)) {
        $message = str_replace($amount[0], '', $message);
        $amount[0] = str_replace(',', '.', $amount[0]);
        $amount = (float)$amount[0];
    } else {
        throw new LogicException('Amount not found');
    }

    if (preg_match('#\d+#', $message, $password)) {
        $password = $password[0];
    } else {
        throw new LogicException('Password not found');
    }

    return [$password, $amount, $account];    
}
