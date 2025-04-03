<?php

function toPersianNumbers($number) {
    $persianDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    return str_replace(range(0, 9), $persianDigits, $number);
}
