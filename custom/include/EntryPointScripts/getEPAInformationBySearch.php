<?php

// http://localhost/haztrac/#bwc/index.php?entryPoint=getEPAInformationBySearch
// https://rcrapublic.epa.gov/rcrainfoweb/action/modules/hd/showhdcurrent/false/null/null/null/HIR009719056
// https://rcrapublic.epa.gov/rcrainfoweb/action/modules/hd/handlersearch2/false/ALL/null/null/null/ALL/ALL/HONOLULU/96819/DANIEL+K.+INOUYE+%28IMO+9719056%29/PIER+51+SAND+ISLAND+ACCESS+RD
// https://rcrapublic.epa.gov/rcrainfoweb/action/modules/hd/handlersearch2/false/HI/null/null/null/ALL/ALL/HONOLULU/96819/DANIEL+K.+INOUYE+%28IMO+9719056%29/PIER+51+SAND+ISLAND+ACCESS+RD
// https://rcrapublic.epa.gov/rcrainfoweb/action/modules/hd/handlersearch2/false/ALL/null/null/null/ALL/ALL/HONOLULU/96819/null/PIER+51+SAND+ISLAND+ACCESS+RD
// https://rcrapublic.epa.gov/rcrainfoweb/action/modules/hd/handlerindex

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

$siteIdsList = array();
// Randon number for the file name
$randomNumber = rand();
//$randomNumber = "971483025";
$randomNumber = "1383088515";

$city = urlencode("Honolulu");
$street = urlencode("Pier 51 SAND ISLAND ACCESS RD");
$postalcode = urlencode("96819");
$link = "https://rcrapublic.epa.gov/rcrainfoweb/action/modules/hd/handlersearch2/false/ALL/null/null/null/ALL/ALL/{$city}/{$postalcode}/null/{$street}";
$fileName = "epaInfoDir/{$randomNumber}.html";

//unlink($fileName);
$command = "wget -c -O $fileName $link";
//exec($command);

$headerStr = $tableStr = '';
$dom = new domDocument;
if ($dom->loadHTMLFile($fileName)) {
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
        $element->setAttribute('rel', 'stylesheet');
        $element->setAttribute('type', 'text/css');
        $element->setAttribute('href', 'epaInfoDir/cssFiles/font-awesome-4.7.0/css/font-awesome.min.css');
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

    print '<pre>';
    $tables = $dom->getElementsByTagName('table');
    foreach ($tables as $table) {
//        print_r($table);
        if ($table->getAttribute('id') == "searchResult") {
            foreach ($table->getElementsByTagName('tr') as $tr) {
                // insert into thead > th
                if ($tr->childNodes->item(0)->nodeName == 'th') {
                    $th = $dom->createElement('th');
                    $th->setAttribute('class', 'sortable');
                    $th->setAttribute('scope', 'col');
                    $th->nodeValue = 'View Info';
                    $tr->appendChild($th);
                } else {
                    // insert into body > td
                    $td = $dom->createElement('td');
                    $td->setAttribute('scope', 'row');
                    $td->setAttribute("style", "text-align: center;");

                    $element1 = $dom->createElement('a');
                    $element1->setAttribute('name', 'eyeball-' . $tr->childNodes->item(0)->nodeValue);
                    $element1->setAttribute('onclick', "showInfo(this)");

                    $element2 = $dom->createElement('i');
                    $element2->setAttribute('class', 'fa fa-eye');
                    $element1->appendChild($element2);

                    $td->appendChild($element1);

                    $tr->appendChild($td);

                    array_push($siteIdsList, trim($tr->childNodes->item(0)->nodeValue));
                }
            }
        }
        $tableStr .= $dom->saveHTML($table) . PHP_EOL;
    }
    print '</pre>';

    $scriptStartHTML = '<head>
    <script src="epaInfoDir/cssFiles/jquery-3.5.1.min.js"></script>
</head>
<script>
    function showInfo(ele) {
        var divId = ele.name + "-div";

        if ($("[name=" + divId + "]").is(":visible") != true) {
            // First hide all the divs and remove eyeball background, and then show this clicked one
            $("div[name*=-div]").hide();
            $("[name*=eyeball-]").css({"background-color": ""});

            $("[name=" + ele.name + "]").css({"background-color": "gold"});
            $("[name=" + divId + "]").show();
        } else {
            $("[name=" + ele.name + "]").css({"background-color": ""});
            $("[name=" + divId + "]").hide();
        }
    }
</script>';

    foreach ($siteIdsList as $key => $value) {
        $html = getEPAInformationBySiteId($value);
        $scriptEndHTML .= "<div name='eyeball-{$value}-div' style='display: none;'>
    {$html}
</div>";
    }


    $html = $scriptStartHTML . ' ' . $headerStr . ' ' . $tableStr . $scriptEndHTML;
    $html = str_replace('<br><br>', '', $html);
    $html = str_replace('style="width:95%;"', 'style="width:100%;font-size: initial;"', $html);
    echo $html;

    file_put_contents("epaInfoDir/{$randomNumber}-1.html", $html);
    return "epaInfoDir/{$randomNumber}-1.html";
}

function getEPAInformationBySiteId($epaId) {
//    $epaId = 'HIR009719056';
//    unlink("epaInfoDir/{$epaId}");
    if (!file_exists('epaInfoDir/' . $epaId)) {
        exec("wget -P epaInfoDir https://rcrapublic.epa.gov/rcrainfoweb/action/modules/hd/showhdcurrent/false/null/null/null/{$epaId}");
    }

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
//        echo $html;

        file_put_contents("epaInfoDir/{$epaId}.html", $html);
//        return "epaInfoDir/{$epaId}.html";
        return $html;
    }
}
