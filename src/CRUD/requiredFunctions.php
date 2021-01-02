<?php

use JetBrains\PhpStorm\Pure;

#[Pure] function randomColor(): string {
    return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
}