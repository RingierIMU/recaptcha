<?php
if (!function_exists('renderDataAttributes')) {
    function renderDataAttributes($attributes)
    {
        $mapped = [];
        foreach ($attributes as $key => $value) {
            $mapped[] = 'data-' . $key . '="' . $value . '"';
        };

        return implode(' ', $mapped);
    }
}
?>
<script
    src='https://www.google.com/recaptcha/api.js?render=onload{{ (isset($lang) ? '&hl=' . $lang : '') }}'
    async
    defer
></script>
<div
    class="g-recaptcha"
    data-sitekey="{{ $public_key }}"
    data-size="invisible"
    <?= renderDataAttributes($dataParams) ?>
></div>
