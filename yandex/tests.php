<?php
use PHPUnit\Framework\TestCase;

require 'parser.php';

class ParseMessageTest extends TestCase
{

    /**
     * @dataProvider rightProvider
     */
    public function testRightData($message, $expected)
    {
        $result = parseMessage($message);
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider wrongProvider
     */
    public function testWrongData($message, $expected)
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage($expected);
        $result = parseMessage($message);
    }

    public function rightProvider()
    {
        return [
            [
                'Пароль: 6846 Спишется 1,01р. Перевод на счет 4100135782285',
                [6846, 1.01, 4100135782285]
            ],
            [
                'Спишется 1,01р. Пароль: 6846 Перевод на счет 4100135782285',
                [6846, 1.01, 4100135782285]
            ],
            [
                'Перевод на счет 4100135782285 Спишется 1,01р. Пароль: 6846',
                [6846, 1.01, 4100135782285]
            ],
            [
                'Перевод на счет 4100135782285 Пароль: 6846 Спишется 1,01р.',
                [6846, 1.01, 4100135782285]
            ],
            [
                'Пароль: 6846
Спишется 12р.
Перевод на счет 41001357122825',
                [6846, 12, 41001357122825]
            ],
            [
                'Пароль: 4100135
Спишется 1.01р.
Перевод на счет 4100135712285',
                [4100135, 1.01, 4100135712285]
            ],
        ];
    }

    public function wrongProvider()
    {
        return [
            [
                'Пароль: 6846 Спишется 1,01р. Перевод на счет 6846',
                'Account not found'
            ],
            [
                'Пароль: 6846 Спишется 1.,01р. Перевод на счет 4100135782285',
                'Amount not found'
            ],
            [
                'Пароль: 6846 Спишется 1. ,01р. Перевод на счет 4100135782285',
                'Amount not found'
            ],
            [
                'Пароль: 6846 Спишется 1,,01р. Перевод на счет 4100135782285',
                'Amount not found'
            ],
            [
                'Пароль: 6846 Спишется 1..01р. Перевод на счет 4100135782285',
                'Amount not found'
            ],
            [
                'Пароль: 6846 Спишется 1. 01р. Перевод на счет 4100135782285',
                'Amount not found'
            ],
            [
                'Пароль: qwe Спишется 1.01р. Перевод на счет 4100135782285',
                'Password not found'
            ],
            [
                'Пароль:  Спишется 1.01р. Перевод на счет 4100135782285',
                'Password not found'
            ],
        ];

    }
}
