<?php

// http://localhost/haztrac/signDoc/annotationeer/annotations/getSignatures.php?sugar_user_id=1

require_once '../../../config.php';
require_once 'signDoc_utils.php';
require_once 'signDoc_dbConnection.php';

$sugar_user_id = $_GET['sugar_user_id'];
$document_id = $_GET['document_id'];

$innerIdsCounter = 1;

$returnData = array(
    'settings' => array(
        array(
            'key' => "ANNOTATIONS_READ_ONLY",
            'value' => "false",
        ),
    ),
    'annotations' => array(),
    'digital_signatures' => array(),
    'stamps' => array(),
    'bookmarks' => array(),
);

$sql = "SELECT * FROM signdoc_user_signatures where sugar_user_id='{$sugar_user_id}'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($returnData['digital_signatures'], array(
            'id' => $row["signature_id"],
//            'id' => $row["id"],
            'username' => "",
            'signature' => $row["signature"],
            'width' => $row["width"],
            'height' => $row["height"],
        ));
    }
}

$fieldsMappingList = array(
    'annotationType' => 'annotation_type_id',
    'backgroundColor' => 'background_color',
    'calibrationMeasurementType' => 'calibration_measurement_type_id',
    'calibrationValue' => 'calibration_value',
    'color' => 'color',
    'comments' => 'comments',
    'dateCreated' => 'date_created',
    'dateModified' => 'date_modified',
    'docId' => 'doc_id',
    'drawingPositions' => 'drawing_positions',
    'font' => 'font',
    'fontSize' => 'font_size',
    'formFieldName' => 'form_field_name',
    'formFieldValue' => 'form_field_value',
//    'highlightTextRects' => 'highlight_text_rects',
    'icon' => 'icon',
    'id' => 'id',
    'lineStyle' => 'line_style_id',
    'lineWidth' => 'line_width',
    'measurementType' => 'measurement_type_id',
    'opacity' => 'opacity',
    'pageHeight' => 'page_height',
    'pageIndex' => 'page_index',
    'pageWidth' => 'page_width',
    'readOnly' => 'read_only',
    'readOnlyComment' => 'read_only_comment',
    'text' => 'text',
//    'origH' => 'coordinate',
//    'origW' => '',
//    'origX' => '',
//    'origY' => '',
);

$sql = "SELECT * FROM signdoc_annotations where document_id='{$document_id}' AND deleted=0 ORDER BY annotation_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        $fetchedAnnotation = json_decode($row['annotation']);


        $annotation = array();
        foreach ($fieldsMappingList as $key => $value) {
            $annotation[$value] = $fetchedAnnotation->$key;
        }
        $annotation['document_id'] = $row['document_id'];
        $annotation['id'] = $row['annotation_id'];
        $annotation['coordinate'] = $fetchedAnnotation->origX . "," . $fetchedAnnotation->origY . "," .
                $fetchedAnnotation->origW . "," . $fetchedAnnotation->origH;

        // For Text Highlighting etc...
        $annotation['highlight_text_rects'] = array();
        foreach ($fetchedAnnotation->highlightTextRects as $key => $dimension) {
            ///////////////////////////
//            error_log(print_r($dimension, TRUE));

            $highlightTextRects = array();

            $highlightTextRects['annotation_id'] = $row['annotation_id'];
            $highlightTextRects['coordinate'] = $dimension->origLeft . "," . $dimension->origTop . "," .
                    $dimension->origWidth . "," . $dimension->origHeight;
            $highlightTextRects['dom_rotate_angle'] = $dimension->domRotateAngle;
            $highlightTextRects['id'] = $innerIdsCounter;

//            error_log(print_r($highlightTextRects, TRUE));

            array_push($annotation['highlight_text_rects'], $highlightTextRects);
            $innerIdsCounter++;
        }

        // For Drawing etc...
        $annotation['drawing_positions'] = array();
        foreach ($fetchedAnnotation->drawingPositions as $key => $dimension) {
            ///////////////////////////
//            error_log(print_r($dimension, TRUE));

            $drawingPositions = array();

            $drawingPositions['annotation_id'] = $row['annotation_id'];
            $drawingPositions['coordinate'] = $dimension->origX . "," . $dimension->origY;
            $drawingPositions['id'] = $innerIdsCounter;

//            error_log(print_r($drawingPositions, TRUE));

            array_push($annotation['drawing_positions'], $drawingPositions);
            $innerIdsCounter++;
        }

        // Stamp
        if ($annotation['annotation_type_id'] == '12' || $annotation['annotation_type_id'] == '23') {
            $annotation['icon'] = $fetchedAnnotation->iconSrc;
        }

        array_push($returnData['annotations'], $annotation);
    }
}


mysqli_close($conn);

echo json_encode($returnData);

// SAMPLE DATA
//$returnData = array(
//    'settings' => array(
//        array(
//            'key' => "ANNOTATIONS_READ_ONLY",
//            'value' => "false",
//        ),
//    ),
//    'annotations' => array(),
//    'digital_signatures' => array(
//        array(
//            'id' => "9",
//            'username' => "Username",
//            'signature' => "data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj48c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgdmVyc2lvbj0iMS4xIiB3aWR0aD0iMjAyIiBoZWlnaHQ9Ijg0Ij48cGF0aCBzdHJva2UtbGluZWpvaW49InJvdW5kIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlPSJyZ2IoNDMsIDQ2LCA1NikiIGZpbGw9Im5vbmUiIGQ9Ik0gMiA4IGMgMC4wNyAwLjMzIDMgMTIuNzMgNCAxOSBjIDAuMzEgMS45NCAtMC40MSA0LjIyIDAgNiBjIDAuNTIgMi4yNiAyLjYyIDQuNzEgMyA3IGMgMC41NSAzLjMxIC0wLjcyIDcuNTYgMCAxMSBjIDIuMTggMTAuMzkgOSAzMiA5IDMyIi8+PHBhdGggc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZT0icmdiKDQzLCA0NiwgNTYpIiBmaWxsPSJub25lIiBkPSJNIDEgMiBjIDAuMTggLTAuMDIgNi45MSAtMS4yOSAxMCAtMSBjIDMuNTEgMC4zMyA3LjM1IDIuODUgMTEgMyBjIDIwLjE2IDAuODIgNjMgMCA2MyAwIi8+PHBhdGggc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZT0icmdiKDQzLCA0NiwgNTYpIiBmaWxsPSJub25lIiBkPSJNIDE2IDQ5IGMgMC4yMSAwLjAyIDguMTYgMC4zNiAxMiAxIGMgMi4wMiAwLjM0IDQuMDIgMS45MSA2IDIgYyAxMS42MSAwLjU0IDM3IDAgMzcgMCIvPjxwYXRoIHN0cm9rZS1saW5lam9pbj0icm91bmQiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2U9InJnYig0MywgNDYsIDU2KSIgZmlsbD0ibm9uZSIgZD0iTSA3OCA3NSBsIDEgMSIvPjxwYXRoIHN0cm9rZS1saW5lam9pbj0icm91bmQiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2U9InJnYig0MywgNDYsIDU2KSIgZmlsbD0ibm9uZSIgZD0iTSA4OSAzMyBjIDAuMDUgMC4wNyAyLjY3IDIuNiAzIDQgYyAwLjg2IDMuNjQgMC4zIDguNzcgMSAxMyBjIDAuNjIgMy43IDIuMzMgNy40MSAzIDExIGMgMC4zIDEuNTcgMCA1IDAgNSIvPjxwYXRoIHN0cm9rZS1saW5lam9pbj0icm91bmQiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2U9InJnYig0MywgNDYsIDU2KSIgZmlsbD0ibm9uZSIgZD0iTSAxMTkgMjQgYyAtMC4wNSAwLjA1IC0yLjM5IDEuOTMgLTMgMyBjIC0wLjU5IDEuMDQgLTAuNDMgMi44NSAtMSA0IGMgLTEuMDEgMi4wMSAtMi41IDQuMDggLTQgNiBjIC0zLjI0IDQuMTcgLTkuMzggOS41MyAtMTAgMTIgYyAtMC4yOSAxLjE0IDMuODggMy40MiA2IDQgYyA4LjA4IDIuMiAxNy44MyAyLjk0IDI3IDUgYyAxMC42OSAyLjQgMjAuNCA0Ljk3IDMxIDggYyAxMS4xIDMuMTcgMjIuMTYgNi40NSAzMiAxMCBsIDQgMyIvPjwvc3ZnPg==",
//            'width' => "202",
//            'height' => "84",
//        ),
//        array(
//            'id' => "8",
//            'username' => "Username",
//            'signature' => "data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj48c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgdmVyc2lvbj0iMS4xIiB3aWR0aD0iMzUwIiBoZWlnaHQ9IjEwMyI+PHBhdGggc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZT0icmdiKDQzLCA0NiwgNTYpIiBmaWxsPSJub25lIiBkPSJNIDEyIDEwMiBjIDAuMTkgLTAuMTQgNy40NyAtNS4xNyAxMSAtOCBjIDEuNDcgLTEuMTggMi44OCAtMi41NiA0IC00IGMgMS4xNiAtMS40OSAyLjUyIC0zLjI4IDMgLTUgYyAxLjA4IC0zLjg5IDEuNTggLTguNjQgMiAtMTMgYyAwLjI1IC0yLjY1IC0wLjMyIC01LjM3IDAgLTggYyAwLjY4IC01LjY3IDIuNzMgLTExLjMgMyAtMTcgYyAwLjcyIC0xNS4xOSAtMC43OCAtMzkgMCAtNDYgYyAwLjA5IC0wLjc4IDMuOTQgMC4wOCA1IDEgYyAzLjI0IDIuODEgNy4xNyA3Ljc1IDEwIDEyIGMgMy4wOSA0LjYzIDUuMDYgMTAuMDQgOCAxNSBjIDIuNDkgNC4yMSA1Ljg5IDcuNzcgOCAxMiBjIDMuNDggNi45NyA2LjQ5IDE0LjQ3IDkgMjIgYyAyLjE4IDYuNTMgMy4wNSAxMy40MyA1IDIwIGMgMC43MiAyLjQzIDMuMzcgNi4zOSAzIDcgYyAtMC4zMSAwLjUxIC00LjUyIC0wLjk2IC02IC0yIGMgLTEuNSAtMS4wNSAtMi41MSAtMy41MSAtNCAtNSBjIC0yLjE1IC0yLjE1IC01LjA3IC0zLjc3IC03IC02IGMgLTIuMjYgLTIuNjEgLTMuNzEgLTYuMTYgLTYgLTkgYyAtOC44NiAtMTEuMDEgLTE4LjY1IC0yMS4xMiAtMjcgLTMyIGMgLTIuNSAtMy4yNiAtMy42IC04LjYgLTYgLTExIGMgLTEuNjMgLTEuNjMgLTUuMzkgLTIuNTYgLTggLTMgYyAtMy4wNiAtMC41MSAtNy4zNCAtMC43MSAtMTAgMCBjIC0xLjcgMC40NSAtMy45NSAyLjUgLTUgNCBjIC0xLjA0IDEuNDggLTEuNzUgMy45OSAtMiA2IGMgLTAuNzIgNS43MyAtMS43NyAxMi45OCAtMSAxOCBjIDAuNCAyLjYzIDMuMTEgNS43NCA1IDggYyAxLjI4IDEuNTQgMy4yMSAyLjk4IDUgNCBjIDIuNzUgMS41NyA1Ljk2IDIuODMgOSA0IGMgMS4yNyAwLjQ5IDIuNjcgMC45OCA0IDEgYyAxNi40NiAwLjMgMzUuMzIgMC41NiA1MSAwIGMgMS42NiAtMC4wNiAzLjYxIC0xLjEzIDUgLTIgYyAxLjEgLTAuNjkgMi4zOSAtMS45MyAzIC0zIGMgMC41OSAtMS4wNCAwLjkxIC0yLjY3IDEgLTQgYyAwLjI0IC0zLjU0IDAuMyAtNy4zIDAgLTExIGMgLTAuNzEgLTguOCAtMi4yMiAtMTcuMjEgLTMgLTI2IGMgLTAuMjQgLTIuNjkgMC4wNiAtNy44MyAwIC04IGMgLTAuMDQgLTAuMTEgLTEuMzUgMy41MyAtMSA1IGMgMi42NCAxMS4xMSA3LjgzIDI5LjY2IDExIDM3IGMgMC40MSAwLjk1IDMuNTQgLTAuMzIgNSAwIGMgMS4zIDAuMjkgMi44MSAxLjE3IDQgMiBjIDIuMDcgMS40NSA0LjMzIDMuMTYgNiA1IGMgMS41NCAxLjcgMi44NiA1LjU3IDQgNiBjIDAuNzkgMC4zIDMuMDMgLTEuODcgNCAtMyBjIDAuODcgLTEuMDEgMS4xMiAtMy4xMiAyIC00IGMgMC44OCAtMC44OCAzLjAxIC0yLjI3IDQgLTIgYyAxLjkgMC41MiA0Ljc3IDQuMDcgNyA1IGMgMS4zIDAuNTQgMy42MSAwLjQyIDUgMCBjIDEuNjIgLTAuNDkgMy40IC0yLjkyIDUgLTMgYyA0LjE2IC0wLjIxIDEwLjMgMiAxNSAyIGMgMi44NyAwIDYuMjEgLTEuOCA5IC0yIGMgMS41NCAtMC4xMSAzLjQ3IDEuMTcgNSAxIGwgMTMgLTMiLz48cGF0aCBzdHJva2UtbGluZWpvaW49InJvdW5kIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlPSJyZ2IoNDMsIDQ2LCA1NikiIGZpbGw9Im5vbmUiIGQ9Ik0gMTg0IDI3IGMgMC4wMiAwLjE2IDAuMyA2LjIxIDEgOSBjIDAuNTkgMi4zNCAxLjczIDQuODkgMyA3IGMgMS42NiAyLjc3IDQuMzIgNS4yNyA2IDggYyAwLjkxIDEuNDcgMS4wOSAzLjU3IDIgNSBjIDEuMzIgMi4wOCAzLjk4IDMuNzcgNSA2IGMgNC4zNSA5LjQ4IDEyIDMxIDEyIDMxIi8+PHBhdGggc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZT0icmdiKDQzLCA0NiwgNTYpIiBmaWxsPSJub25lIiBkPSJNIDIzMyA0NSBjIC0wLjA1IDAuMDkgLTIuMzMgMy4yNCAtMyA1IGMgLTEuOTMgNS4wNyAtNC4zNSAxMS40NiAtNSAxNiBjIC0wLjIxIDEuNDYgMC45MiA0LjI0IDIgNSBjIDEuNjUgMS4xNiA1LjgyIDEuMDEgOCAyIGMgMS4xMiAwLjUxIDEuODMgMi41MSAzIDMgYyA2LjEgMi41NCAyMSA3IDIxIDciLz48cGF0aCBzdHJva2UtbGluZWpvaW49InJvdW5kIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlPSJyZ2IoNDMsIDQ2LCA1NikiIGZpbGw9Im5vbmUiIGQ9Ik0gMjY0IDcxIGwgMSAxIi8+PHBhdGggc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZT0icmdiKDQzLCA0NiwgNTYpIiBmaWxsPSJub25lIiBkPSJNIDI5NCA3MyBjIDAuMzMgMCAxMi41NiAwLjIyIDE5IDAgYyAzLjQgLTAuMTIgNy4xMSAtMC4zMyAxMCAtMSBjIDEuMDQgLTAuMjQgMS45NiAtMS42NSAzIC0yIGMgMS43NSAtMC41OCAzLjk4IC0wLjkxIDYgLTEgYyA1LjYzIC0wLjI0IDE3IDAgMTcgMCIvPjwvc3ZnPg==",
//            'width' => "350",
//            'height' => "103",
//        ),
//        array(
//            'id' => "6",
//            'username' => "Username",
//            'signature' => "data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj48c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgdmVyc2lvbj0iMS4xIiB3aWR0aD0iMTMzIiBoZWlnaHQ9IjEwNyI+PHBhdGggc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZT0icmdiKDQzLCA0NiwgNTYpIiBmaWxsPSJub25lIiBkPSJNIDM1IDU4IGMgLTAuMyAwLjAzIC0xMS4zNSAxLjgzIC0xNyAyIGMgLTUuNjIgMC4xNyAtMTQuMzQgMC41NyAtMTcgLTEgYyAtMS40MSAtMC44MyAtMC44MiAtNi40NCAwIC05IGMgMS42MyAtNS4wOCA0Ljg3IC0xMC45OSA4IC0xNiBjIDMuNSAtNS42IDcuNjggLTEwLjcyIDEyIC0xNiBjIDQuOSAtNS45OSAxNC44OCAtMTcuNzggMTUgLTE3IGMgMC4xNyAxLjEzIC05LjI0IDE5LjgzIC0xMyAzMCBjIC0xLjkgNS4xMyAtMy4yOCAxMS4xOCAtNCAxNiBjIC0wLjE4IDEuMiAwLjIzIDMuOTEgMSA0IGMgMy4wMiAwLjM2IDEwLjg3IC0wLjYzIDE2IC0yIGMgMTQuNyAtMy45MiAzOS42NSAtMTMuMjYgNDQgLTE0IGMgMC43MiAtMC4xMiAtMS41OSA1LjEzIC0zIDcgYyAtMi4zNSAzLjEzIC02LjI5IDUuNzggLTkgOSBjIC0yLjYgMy4wOSAtNC4zNiA3LjA1IC03IDEwIGMgLTIuOTEgMy4yNiAtOS40NiA3LjUxIC0xMCA5IGMgLTAuMjUgMC43IDQuMDMgMS43NyA2IDIgYyAzLjQzIDAuNCA3LjQ2IC0wLjI0IDExIDAgYyAxLjMzIDAuMDkgMy41NCAwLjMxIDQgMSBjIDAuNTYgMC44NCAwLjM3IDMuNTIgMCA1IGMgLTAuNTYgMi4yNSAtMy4xNSA1LjgxIC0zIDcgYyAwLjA4IDAuNjQgNC4wNiAwLjQzIDQgMSBjIC0wLjE1IDEuMzEgLTMuMSA1LjUyIC01IDggYyAtMi40MiAzLjE3IC01LjIxIDYuMjEgLTggOSBjIC0xLjE2IDEuMTYgLTQuMjMgMi45NSAtNCAzIGMgMC40MyAwLjA5IDYuMDkgLTEuMDMgOSAtMiBjIDYuMSAtMi4wMyAxMS43NSAtNC45NiAxOCAtNyBjIDExLjQ3IC0zLjc1IDIyLjcyIC03LjMgMzQgLTEwIGMgMy44MyAtMC45MiA5LjIgLTEuNTYgMTIgLTEgbCAzIDQiLz48L3N2Zz4=",
//            'width' => "133",
//            'height' => "107",
//        ),
//        array(
//            'id' => "7",
//            'username' => "Username",
//            'signature' => "data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj48c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgdmVyc2lvbj0iMS4xIiB3aWR0aD0iMzkyIiBoZWlnaHQ9Ijc3Ij48cGF0aCBzdHJva2UtbGluZWpvaW49InJvdW5kIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlPSJyZ2IoNDMsIDQ2LCA1NikiIGZpbGw9Im5vbmUiIGQ9Ik0gMzAgMSBsIDEgMSIvPjxwYXRoIHN0cm9rZS1saW5lam9pbj0icm91bmQiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2U9InJnYig0MywgNDYsIDU2KSIgZmlsbD0ibm9uZSIgZD0iTSA5MCA2IGMgLTAuMTIgMC4xOSAtNC4zNiA3LjU5IC03IDExIGMgLTMuMDEgMy44OSAtNi4yMSA4LjAyIC0xMCAxMSBjIC05LjkgNy43OCAtMjAuOTkgMTUuNDQgLTMyIDIyIGMgLTYuMjIgMy43MSAtMTMuNTkgNy4yNSAtMjAgOSBjIC0zLjggMS4wNCAtOS4yOCAwLjYyIC0xMyAwIGMgLTEuNjcgLTAuMjggLTQuMDMgLTEuNzUgLTUgLTMgYyAtMS4wNSAtMS4zNSAtMS43MiAtNC4wMyAtMiAtNiBjIC0wLjM2IC0yLjQ5IC0wLjQxIC01Ljc2IDAgLTggYyAwLjE4IC0xLjAxIDEuNTYgLTMuMzMgMiAtMyBjIDMuMTIgMi4zNCAxMS43NiAxMi42NSAxOCAxOCBjIDIuODYgMi40NSA2LjY3IDQuOTkgMTAgNiBjIDMuNzIgMS4xMyA4LjY0IDEgMTMgMSBjIDUuMDIgMCAxMC40MSAwLjIxIDE1IC0xIGMgNy41NCAtMS45OSAxNy4yNSAtNS4xNyAyMyAtOSBjIDMuMDMgLTIuMDIgNi4xOSAtMTEuMTIgNyAtMTEgYyAwLjc1IDAuMTEgLTAuOTQgMTAuMTIgMCAxMiBjIDAuNDcgMC45NCA0LjM3IDAuNTggNiAwIGMgMi41NiAtMC45MSA1Ljk4IC00LjQ1IDggLTUgYyAwLjc3IC0wLjIxIDIuMzcgMS4xMyAzIDIgYyAxLjggMi40NyAyLjk2IDcuOTggNSA5IGMgMi4xOSAxLjA5IDguMDEgMC4xIDExIC0xIGMgMi43MSAtMSA1LjIzIC00LjQ0IDggLTYgYyAyLjM3IC0xLjMzIDUuNDUgLTIuNzMgOCAtMyBjIDMuMjkgLTAuMzUgNy44MiAxLjIxIDExIDEgYyAxLjI5IC0wLjA5IDMuODggLTEuMzkgNCAtMiBjIDAuMTIgLTAuNTggLTEuOTUgLTIuODQgLTMgLTMgYyAtMi41IC0wLjM4IC03LjYyIC0wLjE5IC0xMCAxIGMgLTIuMTkgMS4wOSAtNC41MiA0LjY4IC02IDcgYyAtMC42NiAxLjA0IC0xLjMyIDMuMDMgLTEgNCBjIDAuNSAxLjUgMi41NSA0LjAzIDQgNSBjIDEuMTUgMC43NyAzLjM2IDEgNSAxIGMgNi40NiAwIDE0LjAzIDAuMTkgMjAgLTEgYyAzLjMzIC0wLjY3IDcuMyAtNC40MiAxMCAtNSBjIDEuMDggLTAuMjMgMi42OCAxLjc4IDQgMiBjIDIuMzUgMC4zOSA2LjE2IDAuNTUgOCAwIGMgMC44MyAtMC4yNSAyLjExIC0yLjI0IDIgLTMgYyAtMC4xNSAtMS4wNSAtMS45NSAtMy42MSAtMyAtNCBjIC0xLjA3IC0wLjQgLTUgMC42NyAtNSAxIGMgMCAwLjM1IDMuMzggMS42OCA1IDIgYyAxLjUxIDAuMyAzLjQ4IDAuNDIgNSAwIGwgMzEgLTEwIi8+PHBhdGggc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZT0icmdiKDQzLCA0NiwgNTYpIiBmaWxsPSJub25lIiBkPSJNIDI2NCAxOSBjIC0wLjEgMC41NCAtNC44MSAyMC42OSAtNiAzMSBjIC0wLjc5IDYuODYgLTAuNSAxNC41NiAwIDIxIGMgMC4xMyAxLjY1IDEuMTMgNC43OCAyIDUgYyAxLjA4IDAuMjcgNC42NCAtMS41NiA2IC0zIGMgMy40OSAtMy43MSA2LjI5IC05LjYgMTAgLTE0IGMgNS4zNSAtNi4zNCAxMy42NCAtMTUuOTIgMTcgLTE4IGMgMC44NyAtMC41NCAyLjk4IDMuMjEgNCA1IGMgMS41NyAyLjc1IDIuNDYgNy40NiA0IDkgYyAwLjc4IDAuNzggMy41NCAwLjQyIDUgMCBjIDIuODcgLTAuODIgNiAtMy4yNSA5IC00IGMgMy4zNiAtMC44NCA4LjgxIC0xLjY3IDExIC0xIGMgMS4wNyAwLjMzIDEuNyAzLjM3IDIgNSBjIDAuMzMgMS44MiAtMC43NSA1LjgzIDAgNiBjIDEuMjMgMC4yNyA3IC00LjE1IDkgLTQgYyAxLjMgMC4xIDIuNTQgMy41NCA0IDUgYyAxLjE0IDEuMTQgMi41OSAyLjM2IDQgMyBjIDIuMDUgMC45MyA1LjQ2IDIuMzEgNyAyIGMgMS4wNiAtMC4yMSAyLjg4IC0yLjY0IDMgLTQgYyAwLjQ0IC00Ljg5IC0xLjQ0IC0xMi45MSAtMSAtMTggYyAwLjE0IC0xLjY1IDEuODIgLTMuNjUgMyAtNSBjIDEuMDEgLTEuMTUgMi43NSAtMi43MiA0IC0zIGMgMS4yOCAtMC4yOCAzLjc2IDAuMjUgNSAxIGMgMS43MiAxLjAzIDMuMDkgNC4wMSA1IDUgbCAyMCA4Ii8+PC9zdmc+",
//            'width' => "392",
//            'height' => "77",
//        ),
//        array(
//            'id' => "10",
//            'username' => "Username",
//            'signature' => "data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj48c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgdmVyc2lvbj0iMS4xIiB3aWR0aD0iMjM0IiBoZWlnaHQ9Ijk3Ij48cGF0aCBzdHJva2UtbGluZWpvaW49InJvdW5kIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlPSJyZ2IoNDMsIDQ2LCA1NikiIGZpbGw9Im5vbmUiIGQ9Ik0gMSAyNiBjIDAgLTAuMTkgLTAuNDMgLTcuNzUgMCAtMTEgYyAwLjE4IC0xLjMyIDEuMTEgLTIuOTggMiAtNCBjIDEuMjcgLTEuNDUgMy4xOCAtMy4xNyA1IC00IGMgNS4xMyAtMi4zMyAxMS40MyAtNS4yIDE3IC02IGMgNy43MyAtMS4xIDE2LjgxIC0wLjcxIDI1IDAgYyA3LjAxIDAuNjEgMTQuMDMgMy4wNCAyMSA0IGMgMi42MSAwLjM2IDUuNTEgLTAuMzYgOCAwIGMgMS45NyAwLjI4IDQuMDMgMS43MiA2IDIgbCA4IDAiLz48cGF0aCBzdHJva2UtbGluZWpvaW49InJvdW5kIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlPSJyZ2IoNDMsIDQ2LCA1NikiIGZpbGw9Im5vbmUiIGQ9Ik0gNDkgMTYgYyAwLjA3IDAuMDkgMy4xMiAzLjI1IDQgNSBjIDEgMS45OSAxLjA4IDQuNzQgMiA3IGMgMy40NCA4LjQ3IDguMTkgMTYuNTYgMTEgMjUgYyAyLjEgNi4zIDMuMTcgMTMuMzYgNCAyMCBjIDAuNDkgMy45MSAtMC41NSA4LjMyIDAgMTIgYyAwLjM5IDIuNjIgMyA4IDMgOCIvPjxwYXRoIHN0cm9rZS1saW5lam9pbj0icm91bmQiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2U9InJnYig0MywgNDYsIDU2KSIgZmlsbD0ibm9uZSIgZD0iTSAxMDkgNjMgbCAxIDEiLz48cGF0aCBzdHJva2UtbGluZWpvaW49InJvdW5kIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlPSJyZ2IoNDMsIDQ2LCA1NikiIGZpbGw9Im5vbmUiIGQ9Ik0gOTggNjUgYyAwLjA3IDAuMDUgMi42MSAyLjYgNCAzIGMgMi44IDAuOCA3LjI2IDEuMjEgMTAgMSBjIDAuOTggLTAuMDggMi4yMiAtMS4yMiAzIC0yIGMgMC43OCAtMC43OCAyIC0yLjE2IDIgLTMgYyAwIC0xLjA0IC0xLjEyIC0zLjEyIC0yIC00IGMgLTAuODggLTAuODggLTIuNzEgLTEuOTEgLTQgLTIgYyAtMy4xOCAtMC4yMSAtOC4zMyAwLjA1IC0xMSAxIGMgLTEuMjEgMC40MyAtMi43MSAyLjY0IC0zIDQgYyAtMC41OCAyLjcyIC0wLjc5IDcuMzEgMCAxMCBjIDAuNjggMi4zMiAzLjEyIDQuOTYgNSA3IGMgMi4wMiAyLjE5IDQuNDkgNC43NSA3IDYgYyAzLjcgMS44NSA4Ljc5IDMuMDcgMTMgNCBjIDEuNTUgMC4zNCAzLjQ1IDAuMjggNSAwIGwgNiAtMiIvPjxwYXRoIHN0cm9rZS1saW5lam9pbj0icm91bmQiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2U9InJnYig0MywgNDYsIDU2KSIgZmlsbD0ibm9uZSIgZD0iTSAxMzUgNTcgYyAtMC4wMiAwLjE2IC0xLjM2IDYuNTEgLTEgOSBjIDAuMjMgMS42IDEuODYgMy42NyAzIDUgYyAwLjcxIDAuODIgMS45NCAxLjY1IDMgMiBjIDIuNyAwLjkgNi4xMSAxLjA0IDkgMiBjIDQuMDcgMS4zNiA4LjQgMyAxMiA1IGMgMi4xNiAxLjIgNiA0LjQgNiA1IGMgMCAwLjQ2IC00LjExIDAuMjkgLTYgMCBjIC0yLjMgLTAuMzUgLTQuNyAtMS4xOCAtNyAtMiBjIC0yLjQxIC0wLjg2IC01LjE5IC0xLjc5IC03IC0zIGMgLTAuODYgLTAuNTcgLTIgLTIuMTYgLTIgLTMgYyAwIC0xLjA0IDEuMDIgLTMuMiAyIC00IGMgMi4yNiAtMS44NSA2Ljk4IC0yLjg0IDkgLTUgYyAyLjQ2IC0yLjYyIDUuNDIgLTcuMzYgNiAtMTEgYyAxLjI0IC03Ljg1IDAuOTIgLTE5LjM3IDAgLTI3IGMgLTAuMjUgLTIuMDQgLTIuODggLTMuODggLTQgLTYgYyAtMi4yMiAtNC4yMSAtNS4zNCAtMTIuMjQgLTYgLTEzIGMgLTAuMjQgLTAuMjcgLTEgMy40IC0xIDUgYyAwIDIuNTMgLTAuMTkgNi4wOCAxIDggYyAyLjYxIDQuMjIgOC40OCA4LjM2IDEyIDEzIGMgMy43NSA0Ljk1IDYuNDEgMTAuNzIgMTAgMTYgYyAyLjE3IDMuMTkgNC4zOCA2LjIgNyA5IGMgNi44MSA3LjMgMTMuNjEgMTQuMDIgMjEgMjEgbCAxNSAxMyIvPjxwYXRoIHN0cm9rZS1saW5lam9pbj0icm91bmQiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2U9InJnYig0MywgNDYsIDU2KSIgZmlsbD0ibm9uZSIgZD0iTSAyMDAgNTMgYyAtMC4wOSAwIC0zLjQ1IC0wLjI4IC01IDAgYyAtMS45NSAwLjM2IC00LjI0IDEuMDUgLTYgMiBjIC0yLjQgMS4yOSAtNC42NyAzLjgzIC03IDUgYyAtMS4zOCAwLjY5IC00LjEyIDAuMjcgLTUgMSBjIC0wLjcxIDAuNTkgLTEuMjcgMi45MiAtMSA0IGMgMC41OSAyLjM1IDQgOCA0IDgiLz48cGF0aCBzdHJva2UtbGluZWpvaW49InJvdW5kIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlPSJyZ2IoNDMsIDQ2LCA1NikiIGZpbGw9Im5vbmUiIGQ9Ik0gMjMzIDgxIGwgMSAxIi8+PC9zdmc+",
//            'width' => "234",
//            'height' => "97",
//        ),
//    ),
//    'stamps' => array(),
//    'bookmarks' => array(),
//);

