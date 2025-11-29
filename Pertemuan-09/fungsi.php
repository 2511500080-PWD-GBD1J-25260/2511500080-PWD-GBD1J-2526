<?php
function bersihkan($str)
{
    return htmlspecialchars(trim($str));
}

function tidakkosong($str)
{
    return strlen(trim($str)) > 0;
}