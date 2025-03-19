<?php
function getTitle($page = '')
{
    $default = "Zakat";
    return $page ? "$page | $default" : $default;
}