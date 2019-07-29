<?php

class SystemFolderAPI extends SugarApi
{
    public function registerApiRest() {
        return array(
            'SystemFolderTree' => array(
                'reqType' => 'POST',
                'path' => array('SystemFolderTree'),
                'pathVars' => array(''),
                'method' => 'getSystemFolderTree',
                'shortHelp' => 'Generates tree structure for provided base',
                'longHelp' => '',
            ),'
            SystemFolderTreeUploadNote' => array(
                'reqType' => 'POST',
                'path' => array('SystemFolderTree', 'UploadNote'),
                'pathVars' => array('', ''),
                'method' => 'uploadNote',
                'shortHelp' => 'Upload File to a record',
                'longHelp' => '',
            ),
        );
    }

    /**
     * @param ServiceBase $api
     * @param array $args
     * @return array
     */
    public function getSystemFolderTree(ServiceBase $api, array $args): array {
        global $sugar_config;

        $path = $sugar_config['folder_base_path'];
        if (empty($path)) {
            throw new SugarApiExceptionNotFound("Path not defined for System Folder");
        }

        if (!empty($args['base'])) {
            $path .= '/' . $args['base'];
        }

        $list = scandir($path);

        $dirs = array();
        $files = array();

        foreach ($list as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            $base = $item;
            if (!empty($args['base'])) {
                $base = $args['base'] . '/' . $item;
            }

            if (is_dir($path . '/' . $item)) {
                $dirs[] = array(
                    'data' => $item,
                    'base' => $base,
                    'file' => false,
                    'attr' => array(
                        'rel' => 'folder'
                    )
                );
            } else {
                $files[] = array(
                    'data' => $item,
                    'base' => $base,
                    'file' => true,
                    'attr' => array(
                        'rel' => 'default'
                    )
                );
            }
        }

        return array_merge($dirs, $files);
    }

    /**
     * @param ServiceBase $api
     * @param array $args
     */
    public function uploadNote(ServiceBase $api, array $args) {
        global $sugar_config;

        $this->requireArgs($args, array('base','link','module','record'));
        if (empty($sugar_config['folder_base_path'])) {
            throw new SugarApiExceptionNotFound("Path not defined for System Folder.");
        }

        $bean = $this->loadBean($api, $args, 'view');
        $linkName = $args['link'];

        if (!$bean->load_relationship($linkName)) {
            throw new SugarApiExceptionNotFound("Unable to load Notes relationship.");
        }

        $file_path = $sugar_config['folder_base_path'] . '/' . urldecode($args['base']);
        $fileInfo = pathinfo($file_path);
        $content = file_get_contents($file_path);

        $note = BeanFactory::getBean('Notes');
        $note->name = $fileInfo['filename'] . '.' . $fileInfo['extension'];
        $note->file_mime_type = mime_content_type($file_path);
        $note->file_ext = $fileInfo['extension'];
        $note->filename = $fileInfo['filename'];
        $note->file_size = strlen($content);
        $note->parent_type = $bean->module_dir;
        $note->parent_id = $bean->id;
        $note->team_id = $bean->team_id;
        $note->team_set_id = $bean->team_set_id;
        $note->acl_team_set_id = $bean->acl_team_set_id;
        $note->assigned_user_id = $bean->assigned_user_id;

        $note->save();

        $uploadFileName = trim($sugar_config['upload_dir'], '/') . '/' . $note->id;
        file_put_contents($uploadFileName, $content);

        $bean->$linkName->add(array($note));
    }
}
