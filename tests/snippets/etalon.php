<?php

/// errors:0
namespace Vendor\Package;

use FooClass;
use BarClass as Bar;
use /** @noinspection PhpUndefinedNamespaceInspection */ OtherVendor\OtherPackage\BazClass;

//////////////
class HRBill extends CSJActiveRecordWithSelectableConnection
{
    /**@name Статусы счетов */
    private const STATUS_NEW = 0; ///< Новый
    private const STATUS_APPROVED = 1; ///< Подтвержден
    private const STATUS_LETTER_OF_GUARANTEE = 2; ///< Гарантийное письмо
    private const STATUS_COPIED = 4; ///< Скопирован
    private const STATUS_REVOKED = 5; ///< Скопирован
    private const STATUS_RETURNED = 6; ///< Оплата возвращена
    private const STATUS_CONSIDERED = 7; ///< На рассмотрении
    private const STATUS_MAIL_SENT = 8; ///< Отправлено письмо
    private const STATUS_TEST = 9; ///< Тестовый
    private const STATUS_CREDITED = 10; ///< Зачислен
    private const STATUS_PARTIAL = 11; ///< Оплачен частично

    /**@name Методы оплат */
    private const PAY_METHOD_BILL_RUB = 1;
    private const PAY_METHOD_CASH = 2;
    private const PAY_METHOD_RECEIPT_RUB = 3;
    private const PAY_METHOD_CHARITY = 4;
    private const PAY_METHOD_BILL_OTHER = 5;
    private const PAY_METHOD_CREDIT_CARD = 7;
    private const PAY_METHOD_BILL_UAH = 9;
    private const PAY_METHOD_RECEIPT_UAH = 10;
    private const PAY_METHOD_BILL_UZS = 15;

    abstract protected function zim(): BazClass;

    public function getBooleanValue(FooClass $data)
    {
        if (is_null($data) === true) {
            return false;
        }

        return true;
    }

    protected static $foo;

    final public static function bar()
    {
        // тело метода
    }
}

//////////////
$a = null;
if ($a > 0) {
    $b = 10;
} else {
    $b = 0;
}

//////////////
$expr = null;
switch ($expr) {
    case 0:
        echo 'First case, with a break';
        break;
    case 1:
        echo 'Second case, which falls through';
    // no break
    case 2:
    case 3:
    case 4:
        echo 'Third case, return instead of break';
        return;
    default:
        echo 'Default case';
        break;
}

//////////////
try {
    // тело try
} catch (FirstExceptionType $e) {
    // тело catch
} catch (OtherExceptionType $e) {
    // тело catch
}

//////////////
function foo_bar(SomeClass $input, &$output, $notices = [])
{
    // тело
}

# или
function foo_baz(
    SomeClass $input,
    &$output,
    $notices = []
) {
    // тело
}

//////////////
$arg1 = $arg2 = $arg3 = null;
$longArgument = $longerArgument = $muchLongerArgument = null;
$foo = null;
bar();
$foo->bar($arg1);
Foo::bar($arg2, $arg3);
$foo->bar(
    $longArgument,
    $longerArgument,
    $muchLongerArgument
);

//////////////
$arg1 = $arg2 = $var1 = $var2 = null;
$closureWithArgs = function ($arg1, $arg2) {
    // тело
};

$closureWithArgsAndVars = function ($arg1, $arg2) use ($var1, $var2) {
    // тело
};
