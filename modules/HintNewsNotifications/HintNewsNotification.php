<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
use Sugarcrm\Sugarcrm\custom\Hint\Logger\Logger as HintLogger;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

class HintNewsNotification extends \Basic implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    const MODULE_NAME = 'HintNewsNotifications';

    public $id;
    public $assigned_user_id;
    public $category;
    public $title;
    public $photo_url;
    public $source_url;
    public $publisher;
    public $article_date;
    public $name;
    public $description;
    public $date_entered;
    public $date_modified;
    public $deleted;

    public $module_dir = self::MODULE_NAME;
    public $module_name = self::MODULE_NAME;
    public $table_name = 'hint_news_notifications';
    public $object_name = 'HintNewsNotification';

    const BEAN_PROPS = [
        'assigned_user_id',
        'category',
        'title',
        'photo_url',
        'source_url',
        'publisher',
        'article_date',
    ];


    /**
     * HintNewsNotification constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setLogger(new HintLogger());
    }

    static function createHintNewsNotification($arguments)
    {
        $bean = \BeanFactory::newBean(self::MODULE_NAME);
        // REMIND: is there a better way to do this?
        foreach (self::BEAN_PROPS as $prop) {
            if (!empty($arguments[$prop])) {
                if ($prop == 'article_date') {
                    $timedate = new \TimeDate();
                    $datetime = $timedate->fromString($arguments[$prop]);
                    $bean->$prop = $datetime->asDb();
                } else {

                    $bean->$prop = $arguments[$prop];
                }
            }
        }
        return $bean->save();
    }

    /*  Structure is
        { 'sugarAuth': some string,
          'targets': { <sugarUserId>: [array of news ids], ... },
          'news": { <newsId>: {newsArticle contents } }
    */
    static function createHintNewsNotificationBeans($arguments)
    {
        // REMIND: LOTS of security checking needs to be added here before we accept this request
        global $current_user;
        $current_user->retrieve('1');

        // REMIND: use sugarAuth somehow
        $targets = $arguments['targets'];
        $newsGroups = $arguments['news'];

        foreach ($targets as $userId => $newsGroupIds) {
            // REMIND: consider bulk creating these at some point
            foreach ($newsGroupIds as $newsGroupId) {
                $newsGroup = $newsGroups[$newsGroupId];
                foreach ($newsGroup as $newsArticle) {
                    $bean = \BeanFactory::newBean(self::MODULE_NAME);
                    $bean->assigned_user_id = $userId;
                    $article_date = $newsArticle['article_date'];
                    $timedate = new \TimeDate();
                    $datetime = $timedate->fromString($article_date);
                    $bean->article_date = $datetime->asDb();
                    $bean->category = $newsArticle['category'];
                    $bean->title = $newsArticle['title'];
                    $bean->publisher = $newsArticle['publisher'];
                    $bean->photo_url = $newsArticle['photo_url'];
                    $bean->source_url = $newsArticle['source_url'];
                    $bean->save();
                }
            }
        }

//        // REMIND: LOTS of security checking needs to be added here before we accept this request
    }

    static function oldCreateHintNewsNotificationBeans($arguments)
    {
        // REMIND: use sugarAuth somehow
        $targets = $arguments['targets'];
        $newsArticles = $arguments['news'];

        $logger = new HintLogger();
        $logger->alert("receiving you..." . print_r($arguments, true));

        foreach ($targets as $target) {
            $userId = $target['userId'];
            // REMIND: consider bulk creating these at some point
            foreach ($target['newsIds'] as $newsId) {
                $bean = \BeanFactory::newBean(self::MODULE_NAME);
                $bean->assigned_user_id = $userId;
                $news = $newsArticles[$newsId];

                $article_date = $news['article_date'];
                $timedate = new \TimeDate();
                $datetime = $timedate->fromString($article_date);
                $bean->article_date = $datetime->asDb();
                $bean->category = $news['category'];
                $bean->title = $news['title'];
                $bean->publisher = $news['publisher'];
                $bean->photo_url = $news['photo_url'];
                $bean->source_url = $news['source_url'];
                $bean->save();
            }
        }
    }

    // old version
//    static function createHintNewsNotificationBeans($arguments)
//    {
//        // REMIND: LOTS of security checking needs to be added here before we accept this request
//        global $current_user;
//        $userId = $arguments['userId'];
//        // make sure we are operating as the desired user
//        $current_user->retrieve($userId);
//        foreach ($arguments['notifications'] as $notification) {
//            $bean = BeanFactory::newBean(self::MODULE_NAME);
//            $bean->assigned_user_id = $userId;
//            $article_date = $notification['article_date'];
//            $timedate = new \TimeDate();
//            $datetime = $timedate->fromString($article_date);
//            $bean->article_date = $datetime->asDb();
//            $bean->category = $notification['category'];
//            $bean->title = $notification['title'];
//            $bean->publisher = $notification['publisher'];
//            $bean->photo_url = $notification['photo_url'];
//            $bean->source_url = $notification['source_url'];
//            $bean->save();
//        }
//    }
}
