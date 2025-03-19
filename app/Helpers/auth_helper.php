<?php

if (!function_exists('is_admin')) {
    function is_admin()
    {
        return session()->get('role') === 'admin';
    }
}

if (!function_exists('is_rt')) {
    function is_rt()
    {
        return session()->get('role') === 'rt';
    }
}

if (!function_exists('is_bendahara')) {
    function is_bendahara()
    {
        return session()->get('role') === 'bendahara';
    }
}