<?php

use JetBrains\PhpStorm\Pure;

#[Pure] function randomColor(): string {
    return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
}

#[PURE] function getMonthString(int $monthNumber): string {
    switch ($monthNumber) {
        case 1:
            return 'Jan';
        case 2:
            return 'Feb';
        case 3:
            return 'Mar';
        case 4:
            return 'Apr';
        case 5:
            return 'May';
        case 6:
            return 'Jun';
        case 7:
            return 'Jul';
        case 8:
            return 'Aug';
        case 9:
            return 'Sept';
        case 10:
            return 'Oct';
        case 11:
            return 'Nov';
        default:
            return 'Dec';
    }
}