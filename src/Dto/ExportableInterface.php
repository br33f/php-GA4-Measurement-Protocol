<?php
/**
 * User: Damian Zamojski (br33f)
 * Date: 22.06.2021
 * Time: 11:10
 */

namespace Br33f\Ga4\MeasurementProtocol\Dto;

interface ExportableInterface
{
    /**
     * Method returns prepared data
     * @return mixed
     */
    public function export();
}