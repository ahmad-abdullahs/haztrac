<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class getEPAInformation extends SugarApi {

    public function registerApiRest() {
        return array(
            'getEPAInformation' => array(
                //request type
                'reqType' => 'GET',
                //endpoint path
                'path' => array('Accounts', '?', 'getEPAInfo'),
                //endpoint variables
                'pathVars' => array('', 'epaID', ''),
                //method to call
                'method' => 'getEPAInformationMethod',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'This will make the call to rcrainfoweb, get the information, '
                . 'santize it and create a HTML file. It returns the path of the HTML file',
            ),
            'getEPAInformationBySearch' => array(
                //request type
                'reqType' => 'GET',
                //endpoint path
                'path' => array('Accounts', '?', '?', '?', 'getEPAInfoBySearch'),
                //endpoint variables
                'pathVars' => array('', 'street', 'state', 'postalcode', ''),
                //method to call
                'method' => 'getEPAInformationBySearchMethod',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'This will make the call to rcrainfoweb, get the information from the search view, '
                . 'santize it and create a HTML file, This code then go over the list of the sites returned and fetch the data'
                . 'on the bases of SiteIds and attach the html in the same file and link it through eye ball and JS. '
                . 'It returns the path of the HTML file',
            ),
        );
    }

    /**
     * https://rcrapublic.epa.gov/rcrainfoweb/action/modules/hd/showhdcurrent/false/null/null/null/HIR009719056
     */
    /*
     * *****************************************************************
     * This function is also called from the scheduler, do make sure the 
     * functionality should work at both the side.
     * *****************************************************************
     */
    public function getEPAInformationMethod($api, array $args) {
        $epaId = $args['epaID'];
        if ($epaId) {
            // $epaId = 'HIR009719056';
            // First delete the file if it exists already
            unlink("epaInfoDir/{$epaId}");
            // Get the content from this website and put in the directory
            exec("wget -P epaInfoDir https://rcrapublic.epa.gov/rcrainfoweb/action/modules/hd/showhdcurrent/false/null/null/null/{$epaId}");

            $headerStr = $fieldsetStr = '';
            $dom = new domDocument;
            // If file is successfully downloaded
            if ($dom->loadHTMLFile('epaInfoDir/' . $epaId)) {
                $dom->preserveWhiteSpace = false;

                $heads = $dom->getElementsByTagName('head');
                foreach ($heads as $head) {
                    // echo $dom->saveHTML($head) . PHP_EOL;
                    $element = $dom->createElement('link');
                    $element->setAttribute('rel', 'stylesheet');
                    $element->setAttribute('type', 'text/css');
                    $element->setAttribute('href', 'cssFiles/rcrainfo-web-main-new.css');
                    $head->appendChild($element);

                    $element = $dom->createElement('link');
                    $element->setAttribute('rel', 'stylesheet');
                    $element->setAttribute('type', 'text/css');
                    $element->setAttribute('href', 'cssFiles/jquery-ui.min.css');
                    $head->appendChild($element);

                    $element = $dom->createElement('link');
                    $element->setAttribute('type', 'text/javascript');
                    $element->setAttribute('href', 'cssFiles/jquery-ui.min.js');
                    $head->appendChild($element);

                    $element = $dom->createElement('link');
                    $element->setAttribute('type', 'text/javascript');
                    $element->setAttribute('href', 'cssFiles/jquery-1.8.3.min.js');
                    $head->appendChild($element);

                    $headerStr .= $dom->saveHTML($head) . PHP_EOL;
                }

                $fieldsets = $dom->getElementsByTagName('fieldset');
                foreach ($fieldsets as $fieldset) {
                    // echo $dom->saveHTML($fieldset) . PHP_EOL;
                    $p = $fieldset->getElementsByTagName('p')->item(0);
                    $fieldset->removeChild($p);
                    $fieldsetStr .= $dom->saveHTML($fieldset) . PHP_EOL;
                }

                $html = $headerStr . ' ' . $fieldsetStr;
                // Replace the br to reduce the empty space
                $html = str_replace('<br><br>', '', $html);
                // Set the width
                $html = str_replace('style="width:95%;"', 'style="width:100%;font-size: smaller;"', $html);
                $html = $this->removeUnnecessaryFiles($html);

                file_put_contents("epaInfoDir/{$epaId}.html", $html);
//                return "epaInfoDir/{$epaId}.html";
                return array(
                    "src" => "epaInfoDir/{$epaId}.html",
                    "html" => $html,
                );
            }
        }
        return '';
    }

    /**
     * Main Link
     * https://rcrapublic.epa.gov/rcrainfoweb/action/modules/hd/handlerindex    
     */
    public function getEPAInformationBySearchMethod($api, array $args) {
//        $statesList = array(
//            "AL" => "ALABAMA",
//            "AK" => "ALASKA",
//            "AS" => "AMERICAN SAMOA",
//            "AZ" => "ARIZONA",
//            "AR" => "ARKANSAS",
//            "CA" => "CALIFORNIA",
//            "CO" => "COLORADO",
//            "CT" => "CONNECTICUT",
//            "DE" => "DELAWARE",
//            "DC" => "DISTRICT OF COLUMBIA",
//            "FL" => "FLORIDA",
//            "GA" => "GEORGIA",
//            "GU" => "GUAM",
//            "HI" => "HAWAII",
//            "ID" => "IDAHO",
//            "IL" => "ILLINOIS",
//            "IN" => "INDIANA",
//            "IA" => "IOWA",
//            "KS" => "KANSAS",
//            "KY" => "KENTUCKY",
//            "LA" => "LOUISIANA",
//            "ME" => "MAINE",
//            "MD" => "MARYLAND",
//            "MA" => "MASSACHUSETTS",
//            "MI" => "MICHIGAN",
//            "MN" => "MINNESOTA",
//            "MS" => "MISSISSIPPI",
//            "MO" => "MISSOURI",
//            "MT" => "MONTANA",
//            "NN" => "NAVAJO NATION",
//            "NE" => "NEBRASKA",
//            "NV" => "NEVADA",
//            "NH" => "NEW HAMPSHIRE",
//            "NJ" => "NEW JERSEY",
//            "NM" => "NEW MEXICO",
//            "NY" => "NEW YORK",
//            "NC" => "NORTH CAROLINA",
//            "ND" => "NORTH DAKOTA",
//            "MP" => "NORTHERN MARIANAS",
//            "OH" => "OHIO",
//            "OK" => "OKLAHOMA",
//            "OR" => "OREGON",
//            "PA" => "PENNSYLVANIA",
//            "PR" => "PUERTO RICO",
//            "RI" => "RHODE ISLAND",
//            "SC" => "SOUTH CAROLINA",
//            "SD" => "SOUTH DAKOTA",
//            "TN" => "TENNESSEE",
//            "TX" => "TEXAS",
//            "TT" => "TRUST TERRITORIES",
//            "UT" => "UTAH",
//            "VT" => "VERMONT",
//            "VI" => "VIRGIN ISLANDS",
//            "VA" => "VIRGINIA",
//            "WA" => "WASHINGTON",
//            "WV" => "WEST VIRGINIA",
//            "WI" => "WISCONSIN",
//            "WY" => "WYOMING",
//        );

        $siteIdsList = array();
        // Randon number for the file name
        $randomNumber = rand();

//        $city = urlencode("Honolulu");
//        $street = urlencode("Pier 51 SAND ISLAND ACCESS RD");
//        $postalcode = urlencode("96819");
//        $state = urlencode($args['state']);
        $street = urlencode($args['street']);
        $postalcode = urlencode($args['postalcode']);

        $searchLevel = "ALL";
//        if (array_key_exists($state, $statesList)) {
//            $searchLevel = $state;
//        } else if (array_search($state, $statesList)) {
//            $searchLevel = array_search($state, $statesList);
//        }
//        $link = "https://rcrapublic.epa.gov/rcrainfoweb/action/modules/hd/handlersearch2/false/ALL/null/null/null/ALL/ALL/{$city}/{$postalcode}/null/{$street}";

        $link = "https://rcrapublic.epa.gov/rcrainfoweb/action/modules/hd/handlersearch2/false/{$searchLevel}/null/null/null/ALL/ALL/null/{$postalcode}/null/{$street}";

        $GLOBALS['log']->fatal('$link : ' . print_r($link, 1));

        $fileName = "epaInfoDir/{$randomNumber}.html";

        unlink($fileName);
        $command = "wget -c -O $fileName $link";
        exec($command);

        $headerStr = $tableStr = $jsContext = $cssContext = '';
        $dom = new domDocument;
        if ($dom->loadHTMLFile($fileName)) {
            $dom->preserveWhiteSpace = false;

            $heads = $dom->getElementsByTagName('head');
            foreach ($heads as $head) {
                // echo $dom->saveHTML($head) . PHP_EOL;
                $element = $dom->createElement('link');
                $element->setAttribute('rel', 'stylesheet');
                $element->setAttribute('type', 'text/css');
                $element->setAttribute('href', 'cssFiles/rcrainfo-web-main-new.css');
                $head->appendChild($element);

                $element = $dom->createElement('link');
                $element->setAttribute('rel', 'stylesheet');
                $element->setAttribute('type', 'text/css');
                $element->setAttribute('href', 'cssFiles/jquery-ui.min.css');
                $head->appendChild($element);

                $element = $dom->createElement('link');
                $element->setAttribute('rel', 'stylesheet');
                $element->setAttribute('type', 'text/css');
                $element->setAttribute('href', 'cssFiles/font-awesome-4.7.0/css/font-awesome.min.css');
                $head->appendChild($element);

                $element = $dom->createElement('link');
                $element->setAttribute('type', 'text/javascript');
                $element->setAttribute('href', 'cssFiles/jquery-ui.min.js');
                $head->appendChild($element);

                $element = $dom->createElement('link');
                $element->setAttribute('type', 'text/javascript');
                $element->setAttribute('href', 'cssFiles/jquery-1.8.3.min.js');
                $head->appendChild($element);

                $headerStr .= $dom->saveHTML($head) . PHP_EOL;
            }

            $tables = $dom->getElementsByTagName('table');
            foreach ($tables as $table) {
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
                            $element2->setAttribute('class', 'fa fa-spinner');
                            $element2->setAttribute('name', 'eyeball-' . $tr->childNodes->item(0)->nodeValue . '-i');
                            $element1->appendChild($element2);

                            $td->appendChild($element1);

                            $tr->appendChild($td);

                            array_push($siteIdsList, trim($tr->childNodes->item(0)->nodeValue));
                        }
                    }
                }
                $tableStr .= $dom->saveHTML($table) . PHP_EOL;
            }

            $scriptStartHTML = '<html>
<body>
    <script src="cssFiles/jquery-3.5.1.min.js"></script>
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
            $("html, body").animate({
                scrollTop: $("[name=" + divId + "]").offset().top
            }, 1000);
        } else {
            $("[name=" + ele.name + "]").css({"background-color": ""});
            $("[name=" + divId + "]").hide();
        }
    }
</script></body>
</html>';

            foreach ($siteIdsList as $key => $value) {
                $scriptEndHTML .= "<div name='eyeball-{$value}-div' style=\"display: none;\"></div>";
            }

            $html = $scriptStartHTML . ' ' . $headerStr . ' ' . $tableStr . $scriptEndHTML;
            $html = str_replace('<br><br>', '', $html);
            $html = str_replace('style="width:95%;"', 'style="width:100%;font-size: initial;"', $html);
            $html = $this->removeUnnecessaryFiles($html);

            file_put_contents("epaInfoDir/{$randomNumber}-1.html", $html);
            return array(
                "src" => "epaInfoDir/{$randomNumber}-1.html",
                "siteIdsList" => $siteIdsList,
            );
        }
    }

    function removeUnnecessaryFiles($html) {
        $html = str_replace('/rcrainfoweb/js/jquery/jquery-1.8.3.js', '', $html);
        $html = str_replace('/rcrainfoweb/js/jquery/ui/1.9.2/jquery-ui.min.css', '', $html);
        $html = str_replace('/rcrainfoweb/js/jquery/ui/1.9.2/jquery-ui.js', '', $html);
        $html = str_replace('/rcrainfoweb/css/rcrainfo-web-main-new.css', '', $html);
        $html = str_replace('/rcrainfoweb%0A%09%09/js/jquery/ui/1.9.2/jquery-ui.min.css', '', $html);
        $html = str_replace('/rcrainfoweb%0A%09%09/js/jquery/ui/1.9.2/jquery-ui.js', '', $html);
        $html = str_replace('https://www.google-analytics.com/analytics.js', '', $html);
        return $html;
    }

}
