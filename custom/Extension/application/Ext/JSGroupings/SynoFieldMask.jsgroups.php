<?php

if (isset($sugar_grp_sidecar)) {
    $js_groupings[] = $sugar_grp_sidecar = array_merge($sugar_grp_sidecar,
        array(
            // SynoFieldMask
            'custom/Synolia/SynoFieldMask/Js/Libs/inputmask/jquery.inputmask.js' => 'include/javascript/sugar_sidecar.min.js',
            'custom/Synolia/SynoFieldMask/Js/Libs/inputmask/jquery.inputmask.extensions.js' => 'include/javascript/sugar_sidecar.min.js',
            'custom/Synolia/SynoFieldMask/Js/Libs/inputmask/jquery.inputmask.numeric.extensions.js' => 'include/javascript/sugar_sidecar.min.js',
            'custom/Synolia/SynoFieldMask/Js/Libs/inputmask/jquery.inputmask.regex.extensions.js' => 'include/javascript/sugar_sidecar.min.js',
            'custom/Synolia/SynoFieldMask/Js/Libs/inputmask/jquery.inputmask.synolia.extensions.js' => 'include/javascript/sugar_sidecar.min.js',
        )
    );
} else {
    $js_groupings[] = $sugar_grp1 = array_merge($sugar_grp1,
        array(
            // SynoFieldMask
            'custom/Synolia/SynoFieldMask/Js/Libs/inputmask/jquery.inputmask.js' => 'include/javascript/sugar_grp1.js',
            'custom/Synolia/SynoFieldMask/Js/Libs/inputmask/jquery.inputmask.extensions.js' => 'include/javascript/sugar_grp1.js',
            'custom/Synolia/SynoFieldMask/Js/Libs/inputmask/jquery.inputmask.numeric.extensions.js' => 'include/javascript/sugar_grp1.js',
            'custom/Synolia/SynoFieldMask/Js/Libs/inputmask/jquery.inputmask.regex.extensions.js' => 'include/javascript/sugar_grp1.js',
            'custom/Synolia/SynoFieldMask/Js/Libs/inputmask/jquery.inputmask.synolia.extensions.js' => 'include/javascript/sugar_grp1.js',
        )
    );
}
