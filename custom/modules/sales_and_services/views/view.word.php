<?php

class sales_and_servicesViewWord extends ViewWord
{
    function getWordContent() {
        global $sugar_config;

        $note_id = create_guid();
        $temp_doc_name = $sugar_config['upload_dir'] . '/' . $note_id;

        $this->templateProcessor->saveAs($temp_doc_name);
        $content = file_get_contents($temp_doc_name);

        $note = BeanFactory::newBean('Notes');

        $note->id = $note_id;
        $note->new_with_id = true;

        $note->name = $this->templateBean->document_name;
        $note->file_mime_type = $this->templateBean->file_mime_type;
        $note->file_ext = $this->templateBean->file_ext;
        $note->file_size = filesize($temp_doc_name);
        $note->filename = $this->templateBean->filename;

        $note->parent_type = 'sales_and_services';
        $note->parent_id = $this->bean->id;

        $note->save();

        return $content;
    }
}
