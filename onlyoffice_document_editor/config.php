<?php

$GLOBALS['builder_path'] = "documentbuilder";
$GLOBALS['pathToTempDir'] = "/var/www/html/haztrac/onlyoffice_document_editor/temp";

/*builder.OpenFile("/var/www/html/onlyoffice_php/docSpace/__1/docTemplate-101.docx");
var oDocument = Api.GetDocument();
oDocument.SearchAndReplace({"searchString": "$company_name", "replaceString": "Ahmad"});
builder.SaveFile("docx", "/var/www/html/onlyoffice_php/docSpace/__1/parsed_docTemplate-101.docx");
builder.CloseFile();*/
/*
-- sudo supervisorctl restart all
-- onlyoffice-documentbuilder /var/www/html/onlyoffice_document_editor/temp/input.1908775179.docbuilder
 *
 * 
// Download the exe from https://www.onlyoffice.com/download.aspx#builder
install this exe and the run the below command to generate the output document from the 
given input file path in the command parameter.
documentbuilder /var/www/html/onlyoffice_document_editor/temp/input.1908775179.docbuilder
        */
?>
