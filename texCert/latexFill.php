<?php
//code snippets 1from https://mike42.me/blog/how-to-generate-professional-quality-pdf-files-from-php

function latexFill ($data, $template, $tmpFile){
    //open template, insert data, save to temp file
    ob_start();
    include ($template);
    file_put_contents($tmpFile, ob_get_clean());
}

function sani($text){
  // Prepare backslash/newline handling
    $text = str_replace("\n", "\\\\", $text); // Rescue newlines
    $text = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $text); // Strip all non-printables
    $text = str_replace("\\\\", "\n", $text); // Re-insert newlines and clear \\
    $text = str_replace("\\", "\\\\", $text); // Use double-backslash to signal a backslash in the input (escaped in the final step).
	
    // Symbols which are used in LaTeX syntax
    $text = str_replace("{", "\\{", $text);
    $text = str_replace("}", "\\}", $text);
    $text = str_replace("$", "\\$", $text);
    $text = str_replace("&", "\\&", $text);
    $text = str_replace("#", "\\#", $text);
    $text = str_replace("^", "\\textasciicircum{}", $text);
    $text = str_replace("_", "\\_", $text);
    $text = str_replace("~", "\\textasciitilde{}", $text);
    $text = str_replace("%", "\\%", $text);
	
     // Brackets & pipes
    $text = str_replace("<", "\\textless{}", $text);
    $text = str_replace(">", "\\textgreater{}", $text);
    $text = str_replace("|", "\\textbar{}", $text);
	
    // Quotes
    $text = str_replace("\"", "\\textquotedbl{}", $text);
    $text = str_replace("'", "\\textquotesingle{}", $text);
    $text = str_replace("`", "\\textasciigrave{}", $text);

    // Clean up backslashes from before
    $text = str_replace("\\\\", "\\textbackslash{}", $text); // Substitute backslashes from first step.
    $text = str_replace("\n", "\\\\", trim($text)); // Replace newlines (trim is in case of leading \\)
    return $text;
}
?>

