<?php

if (!function_exists('formatPrice')) {
    /**
     * Format price with currency symbol on the right
     * 
     * @param float|int $amount
     * @return string
     */
    function formatPrice($amount)
    {
        return number_format($amount, 2) . ' DH';
    }
}
