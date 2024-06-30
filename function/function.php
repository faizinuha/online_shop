<?php
function createExcerpt($text, $maxLength = 100)
{
    $text = strip_tags($text);
    if (strlen($text) > $maxLength) {
        $excerpt = substr($text, 0, $maxLength) . '...';
    } else {
        $excerpt = $text;
    }
    return $excerpt;
}


function time_elapsed_string($datetime, $full = false)
{
    $now = new DateTime();
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $string = [
        'y' => 'year',
        'm' => 'month',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    ];

    foreach ($string as $key => &$value) {
        if ($diff->$key) {
            $value = $diff->$key . ' ' . $value . ($diff->$key > 1 ? 's' : '');
        } else {
            unset($string[$key]);
        }
    }

    if (!$full) {
        $string = array_slice($string, 0, 1);
    }

    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function Rp($number) {
    if (!is_null($number)) {
        return number_format($number, 0, null, '.');
    }
    return "0.000 IDR";
}

