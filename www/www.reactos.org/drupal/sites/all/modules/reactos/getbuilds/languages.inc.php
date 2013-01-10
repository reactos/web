<?php
/*
  PROJECT:    ReactOS Website
  LICENSE:    GNU GPLv2 or any later version as published by the Free Software Foundation
  PURPOSE:    Easily download prebuilt ReactOS Revisions
  COPYRIGHT:  Copyright 2007-2009 Colin Finck <mail@colinfinck.de>
              Copyright 2013 ReactOS Project
  
  charset=utf-8 without BOM
*/

//please also adapt $supported_languages_short 
	$supported_languages = array(
		"en" => "English",
		"de" => "Deutsch (German)",
		"es" => "Español (Spanish)",
		"fr" => "Français (French)",
		"ja" => "日本語 (Japanese)",
		"it" => "Italiano (Italian)",
		"lt" => "Lietuvių (Lithuanian)",
		"pl" => "Polski (Polish)",
		"ru" => "Русский (Russian)",
	);
	
	
    function lang_getfrombrowser ($allowed_languages, $default_language, $lang_variable = null, $strict_mode = true)
    {
        if ($lang_variable === null) {
            $lang_variable = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        } 
        if (empty($lang_variable)) {
            return $default_language;
        } 
        $accepted_languages = preg_split('/,\s*/', $lang_variable);
        $current_lang = $default_language;
        $current_q = 0;
        foreach ($accepted_languages as $accepted_language) {
            $res = preg_match ('/^([a-z]{1,8}(?:-[a-z]{1,8})*)' . '(?:;\s*q=(0(?:\.[0-9]{1,3})?|1(?:\.0{1,3})?))?$/i', $accepted_language, $matches);
            if (!$res) {
                continue;
            } 
            $lang_code = explode ('-', $matches[1]);
            if (isset($matches[2])) {
                $lang_quality = (float)$matches[2];
            } else {
                $lang_quality = 1.0;
            } while (count ($lang_code)) {
                if (in_array (strtolower (join ('-', $lang_code)), $allowed_languages)) {
                    if ($lang_quality > $current_q) {
                        $current_lang = strtolower (join ('-', $lang_code));
                        $current_q = $lang_quality;
                        break;
                    } 
                } 
                if ($strict_mode) {
                    break;
                } 
                array_pop ($lang_code);
            } 
        } 
        return $current_lang;
    } 
	function get_language()
    {
        if (!isset($_SESSION['language'])) {
			$supported_languages_short = array("en", "de", "es", "fr", "ja", "it", "lt", "pl", "ru");
            $language = lang_getfrombrowser($supported_languages_short, "en", null, false);
            $_SESSION['language'] = $language;
            return $language;
        } else {
            return $_SESSION['language'];
        } 
    } 
?>
