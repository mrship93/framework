<?php


/**
 * Функция приводит вывод массива к читаемому виду
 * @param $arr
 * @return $arr
 */
function debug($arr) {
    echo '<pre>' . print_r($arr, true) .'</pre>';
}