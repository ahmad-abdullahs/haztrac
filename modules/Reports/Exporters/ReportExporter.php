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
declare(strict_types=1);
namespace Sugarcrm\Sugarcrm\modules\Reports\Exporters;

/**
 * Class ReportExporter
 * @package Sugarcrm\Sugarcrm\modules\Reports\Exporters
 */
class ReportExporter
{
    /**
     * @var ReportExporterInterface
     */
    protected $exporter;

    /**
     * @var array
     */
    protected $typeMapping = [
        'summary' => 'Summation',
        'tabular' => 'RowsAndColumns',
        'detailed_summary' => 'SummationWithDetails',
        'Matrix' => 'Matrix',
    ];

    /**
     * @var array
     */
    protected $formatMapping = [
        'CSV' => 'CSV',
    ];

    /**
     * ReportExporter constructor.
     * @param \Report $reporter
     * @param string $format
     */
    public function __construct(\Report $reporter, string $format = 'CSV')
    {
        $this->reporter = $reporter;
        $this->exporter = $this->getExporter($this->reporter->getReportType(), $format);
    }

    /**
     * @param string $type
     * @param string $format
     * @return ReportExporterInterface
     */
    protected function getExporter(string $type, string $format) : ReportExporterInterface
    {
        $type = isset($this->typeMapping[$type]) ? $this->typeMapping[$type] : '';
        $format = isset($this->formatMapping[$format]) ? $this->formatMapping[$format] : '';

        $class = "Sugarcrm\\Sugarcrm\\modules\\Reports\\Exporters\\" . 'Report' . $format . 'Exporter' . $type;
        $class = class_exists($class) ? $class : 'Notype';
        if (method_exists($class, 'getSubTypeExporter')) {
            $subType = $class::getSubTypeExporter($this->reporter);
            $class .= $subType;
        }
        return new $class($this->reporter);
    }

    /**
     * This function calls the corresponding function of the exporter instance.
     *
     * @return string
     */
    public function export()
    {
        return $this->exporter->export();
    }
}
