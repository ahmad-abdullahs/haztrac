<?php
    /**
     *
     * (c) Copyright Ascensio System SIA 2021
     *
     * Licensed under the Apache License, Version 2.0 (the "License");
     * you may not use this file except in compliance with the License.
     * You may obtain a copy of the License at
     *
     *     http://www.apache.org/licenses/LICENSE-2.0
     *
     * Unless required by applicable law or agreed to in writing, software
     * distributed under the License is distributed on an "AS IS" BASIS,
     * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
     * See the License for the specific language governing permissions and
     * limitations under the License.
     *
     */

    require_once( dirname(__FILE__) . '/config.php' );
    require_once( dirname(__FILE__) . '/common.php' );
    require_once( dirname(__FILE__) . '/functions.php' );

    $user = $_GET["user"];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>ONLYOFFICE Document Editors</title>

        <link rel="icon" href="./favicon.ico" type="image/x-icon" />

        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:900,800,700,600,500,400,300&subset=latin,cyrillic-ext,cyrillic,latin-ext" />

        <link rel="stylesheet" type="text/css" href="css/stylesheet.css" />

        <link rel="stylesheet" type="text/css" href="css/jquery-ui.css" />
    </head>
    <body>
        <form id="form1">
            <header>
                <div class="center">
                    <a href="">
                        <img src ="css/images/logo.svg" alt="ONLYOFFICE" />
                    </a>
                </div>
            </header>
            <div class="center main">
                <table class="table-main">
                    <tbody>
                        <tr>
                            <td class="left-panel section">
                                <div class="help-block">
                                    <span>Upload Existing Document</span>
                                    <div class="clearFix">
                                        <div class="upload-panel clearFix">
                                            <a class="file-upload">Upload file
                                                <input type="file" id="fileupload" name="files" data-url="onlyoffice-crm-docuploader-ajax.php?type=upload&sugar=true&bean=Doc_Manager" />
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="section">
                                <div class="main-panel">
                                    <?php
                                        $storedFiles = getStoredFiles();
                                        if (empty($storedFiles)) { ?>
                                            <span class="portal-name">ONLYOFFICE Document Editors – Welcome!</span>
                                            <span class="portal-descr">
                                                Get started with a demo-sample of ONLYOFFICE Document Editors, the first html5-based editors.
                                                <br /> You may upload your own documents for testing using the "<b>Upload file</b>" button and <b>selecting</b> the necessary files on your PC.
                                            </span>
                                    <?php
                                        } else { ?>
                                            <div class="stored-list">
                                                <span class="header-list">Your documents</span>
                                                <table class="tableHeader" cellspacing="0" cellpadding="0" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <td class="tableHeaderCell tableHeaderCellFileName">Filename</td>
                                                        <td class="tableHeaderCell tableHeaderCellDownload">Download</td>
                                                    </tr>
                                                    </thead>
                                                </table>
                                                <div class="scroll-table-body">
                                                    <table cellspacing="0" cellpadding="0" width="100%">
                                                        <tbody>
                                                            <?php foreach ($storedFiles as &$storeFile) {
                                                                echo '<tr class="tableRow" title="'.$storeFile->name.'">';
                                                                echo ' <td class="contentCells">';
                                                                echo '  <a class="stored-edit '.$storeFile->documentType.'" href="doceditor.php?fileID='.urlencode($storeFile->name).'&user='.htmlentities($user).'" target="_blank">';
                                                                echo '   <span title="'.$storeFile->name.'">'.$storeFile->name.'</span>';
                                                                echo '  </a>';
                                                                echo ' </td>';
                                                                echo ' <td class="contentCells contentCells-icon contentCells-shift">';
                                                                echo '  <a href="webeditor-ajax.php?type=download&name='.urlencode($storeFile->name).'">';
                                                                echo '   <img class="icon-download" src="css/images/download-24.png" alt="Download" title="Download" /></a>';
                                                                echo '  </a>';
                                                                echo ' </td>';
                                                                echo '</tr>';
                                                            } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                    <?php
                                        } ?>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="mainProgress">
                <div id="uploadSteps">
                    <span id="uploadFileName" class="uploadFileName"></span>
                    <div class="describeUpload">After these steps are completed, you can work with your document.</div>
                    <span id="step1" class="step">1. Loading the file.</span>
                    <span class="step-descr">The loading speed depends on file size and additional elements it contains.</span>
                    <br />
                    <span id="step2" class="step">2. Conversion.</span>
                    <span class="step-descr">The file is converted to OOXML so that you can edit it.</span>
                    <br />
                    <div id="blockPassword">
                        <span class="descrFilePass">The file is password protected.</span>
                        <br />
                        <div>
                            <input id="filePass" type="password"/>
                            <div id="enterPass" class="button orange">Enter</div>
                            <div id="skipPass" class="button gray">Skip</div>
                        </div>
                        <span class="errorPass"></span>
                        <br />
                    </div>
                    <span id="step3" class="step">3. Loading editor scripts.</span>
                    <span class="step-descr">They are loaded only once, they will be cached on your computer.</span>
                    <input type="hidden" name="hiddenFileName" id="hiddenFileName" />
                    <br />
                    <br />
                    <span class="progress-descr">Note the speed of all operations depends on your connection quality and server location.</span>
                    <br />
                    <br />
                    <span class="progress-descr">Click the OPEN RECORD button to view the record and set the Module Name, Description and Other fields.</span>
                    <br />
                    <br />
                    <div class="error-message">
                        <b>Upload error: </b><span></span>
                        <br />
                        Please select another file and try again.
                    </div>
                </div>
                <iframe id="embeddedView" src="" height="345px" width="432px" frameborder="0" scrolling="no" allowtransparency></iframe>
                <br />
                <div id="openRecord" class="button gray">Open Record</div>
                <div id="reloadPage" class="button orange">Close</div>
            </div>

            <span id="loadScripts" data-docs="<?php echo $GLOBALS['DOC_SERV_SITE_URL'].$GLOBALS['DOC_SERV_PRELOADER_URL'] ?>"></span>

            <footer>
                <div class="center">
                    <table>
                        <tbody>
                        <tr>
                            <td>
                                <a href="http://api.onlyoffice.com/editors/howitworks" target="_blank">API Documentation</a>
                            </td>
                            <td>
                                <a href="mailto:sales@onlyoffice.com">Submit your request</a>
                            </td>
                            <td class="copy">
                                &copy; Ascensio Systems SIA <?php echo date("Y") ?>. All rights reserved.
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </footer>
        </form>

        <script type="text/javascript" src="js/jquery-1.9.0.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/jquery.blockUI.js"></script>
        <script type="text/javascript" src="js/jquery.iframe-transport.js"></script>
        <script type="text/javascript" src="js/jquery.fileupload.js"></script>
        <script type="text/javascript" src="js/jquery.dropdownToggle.js"></script>
        <script type="text/javascript" src="js/jscript.js"></script>
        <script type="text/javascript">
            var ConverExtList = '<?php echo implode(",", $GLOBALS["DOC_SERV_CONVERT"]) ?>';
            var EditedExtList = '<?php echo implode(",", $GLOBALS["DOC_SERV_EDITED"]) ?>';
        </script>
    </body>
</html>
