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
namespace Sugarcrm\Sugarcrm\custom\Hint\Queue\Processor;

class SimpleEventProcessor implements ProcessorInterface
{
    /**
     * ISS command
     * @var string
     */
    private $command;


    /**
     * SimpleEventProcessor constructor.
     * @param string $command
     */
    public function __construct(string $command)
    {
        $this->command = $command;
    }

    /**
     * Converts processor data to ISS command
     *
     * @param array $data
     * @return array
     */
    public function __invoke(array $data): array
    {
        return array_merge(
            ['command' => $this->getCommandName()],
            // not modified raw data
            $data
        );
    }

    /**
     * Get command name
     * @return string
     */
    public function getCommandName(): string
    {
        return $this->command;
    }

    /**
     * Gets the first available value from the list
     * @param array $data
     * @param array $fields
     * @return mixed|null
     */
    protected function getDefinedValue(array $data, array $fields = [])
    {
        foreach ($fields as $field) {
            if (array_key_exists($field, $data)) {
                return $data[$field];
            }
        }

        return null;
    }
}
