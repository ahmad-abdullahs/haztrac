<?php

// http://localhost/haztrac/#bwc/index.php?entryPoint=TestActionEntryPointRegistry
// https://rcrapublic.epa.gov/rcrainfoweb/action/modules/hd/showhdcurrent/false/null/null/null/HIR009719056

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

$epaId = 'HIR009719056';
unlink("epaInfoDir/{$epaId}");
exec("wget -P epaInfoDir https://rcrapublic.epa.gov/rcrainfoweb/action/modules/hd/showhdcurrent/false/null/null/null/{$epaId}");

$headerStr = $fieldsetStr = '';
$dom = new domDocument;
if ($dom->loadHTMLFile('epaInfoDir/' . $epaId)) {
    $dom->preserveWhiteSpace = false;

    $heads = $dom->getElementsByTagName('head');
    foreach ($heads as $head) {
        // echo $dom->saveHTML($head) . PHP_EOL;
        $element = $dom->createElement('link');
        $element->setAttribute('rel', 'stylesheet');
        $element->setAttribute('type', 'text/css');
        $element->setAttribute('href', 'epaInfoDir/cssFiles/rcrainfo-web-main-new.css');
        $head->appendChild($element);

        $element = $dom->createElement('link');
        $element->setAttribute('rel', 'stylesheet');
        $element->setAttribute('type', 'text/css');
        $element->setAttribute('href', 'epaInfoDir/cssFiles/jquery-ui.min.css');
        $head->appendChild($element);

        $element = $dom->createElement('link');
        $element->setAttribute('type', 'text/javascript');
        $element->setAttribute('href', 'epaInfoDir/cssFiles/jquery-ui.js');
        $head->appendChild($element);

        $element = $dom->createElement('link');
        $element->setAttribute('type', 'text/javascript');
        $element->setAttribute('href', 'epaInfoDir/cssFiles/jquery-1.8.3.js');
        $head->appendChild($element);

        $headerStr .= $dom->saveHTML($head) . PHP_EOL;
    }

    $fieldsets = $dom->getElementsByTagName('fieldset');
    foreach ($fieldsets as $fieldset) {
        $p = $fieldset->getElementsByTagName('p')->item(0);
        $fieldset->removeChild($p);
        // echo $dom->saveHTML($fieldset) . PHP_EOL;
        $fieldsetStr .= $dom->saveHTML($fieldset) . PHP_EOL;
    }

    $html = $headerStr . ' ' . $fieldsetStr;
    $html = str_replace('<br><br>', '', $html);
    $html = str_replace('style="width:95%;"', 'style="width:100%;font-size: initial;"', $html);
    echo $html;

    file_put_contents("epaInfoDir/{$epaId}.html", $html);
    return "epaInfoDir/{$epaId}.html";
}