<?php

use App\Models\Rule;

function generateRandomString($length = 20) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function rules() {
    if($rules = Rule::first())
    return $rules;
    else
    return [];
}

?>