<?php

/*
 * This file is part of the Atico/SpreadsheetTranslator package.
 *
 * (c) Samuel Vicent <samuelvicent@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Atico\SpreadsheetTranslator\Core\Processor;

use Atico\SpreadsheetTranslator\Core\Exporter\ExporterFactory;
use Atico\SpreadsheetTranslator\Core\Exporter\ExporterInterface;
use Atico\SpreadsheetTranslator\Core\Parser\Parser;
use Atico\SpreadsheetTranslator\Core\Provider\ProviderFactory;
use Atico\SpreadsheetTranslator\Core\Provider\ProviderInterface;
use Atico\SpreadsheetTranslator\Core\Resource\ResourceInterface;
use Atico\SpreadsheetTranslator\Core\Configuration\Configuration;

class ProcessorBase
{
    /** @var  array $configuration */
    protected $configuration;

    public function __construct($configuration)
    {
        $this->configuration = $configuration;
    }

    protected function readSourceResource()
    {
        /** @var ProviderInterface $provider */
        $providerFactory = new ProviderFactory();
        $providerConfiguration = new Configuration($this->configuration, 'provider');
        $provider = $providerFactory->create($providerConfiguration);

        /** @var ResourceInterface $resource */
        $resource = $provider->handleSourceResource();
        return $resource;
    }

    protected function parseSheet($sheetName, ResourceInterface $resource)
    {
        $parserConfiguration = new Configuration($this->configuration, 'parser');

        /** @var Parser $parser */
        $parser = new Parser($resource, $parserConfiguration);

        $localizedTranslations = $parser->parseSheet($sheetName);
        return $localizedTranslations;
    }

    protected function saveTranslatedFile(array $localizedTranslations)
    {
        /** @var ExporterInterface $exporter */
        $exporterFactory = new ExporterFactory();
        $exporterConfiguration = new Configuration($this->configuration, 'exporter');

        $exporter = $exporterFactory->create($exporterConfiguration);
        $exporter->save($localizedTranslations);
    }
}