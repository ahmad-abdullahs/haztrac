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
        );
    }

    /**
     * https://rcrapublic.epa.gov/rcrainfoweb/action/modules/hd/showhdcurrent/false/null/null/null/HIR009719056
     */
    public function getEPAInformationMethod(ServiceBase $api, array $args) {
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
                    $element->setAttribute('href', 'cssFiles/jquery-ui.js');
                    $head->appendChild($element);

                    $element = $dom->createElement('link');
                    $element->setAttribute('type', 'text/javascript');
                    $element->setAttribute('href', 'cssFiles/jquery-1.8.3.js');
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

                file_put_contents("epaInfoDir/{$epaId}.html", $html);
                return "epaInfoDir/{$epaId}.html";
            }
        }
        return '';
    }

}
