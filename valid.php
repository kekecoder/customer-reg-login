<?php
// This function is to check and remove any whitespaces using trim and to avoid cross-site scripting
function Valid_input($input)
{
    $input = trim($input);
    $input = htmlspecialchars($input);

    return $input;
}