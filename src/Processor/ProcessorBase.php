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

use Atico\SpreadsheetTranslator\Core\Exception\NoDataToParseException;
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

    /** @var ResourceInterface */
    protected $resource;

    public function __construct($configuration)
    {
        $this->configuration = $configuration;
        $this->resource = null;
    }

    /**
     * @throws \Exception
     */
    public function parseSheetAndSaveIntoTranslatedFile($sheetName)
    {
        $localizedTranslations = $this->parseSheet($sheetName);
        $this->saveTranslatedFile($localizedTranslations, $sheetName);
    }

    /**
     * @throws NoDataToParseException|\Exception
     */
    protected function parseSheet($sheetName)
    {
        $parserConfiguration = new Configuration($this->configuration, 'parser');

        /** @var Parser $parser */
        $parser = new Parser($this->getResource(), $parserConfiguration);
        
        $localizedTranslations = $parser->parseSheet($sheetName);
        return $localizedTranslations;
    }

    /**
     * @throws \Exception
     */
    protected function saveTranslatedFile(array $localizedTranslations, $sheetName)
    {
        /** @var ExporterInterface $exporter */
        $exporterFactory = new ExporterFactory();
        $exporterConfiguration = new Configuration($this->configuration, 'exporter');

        $exporter = $exporterFactory->create($exporterConfiguration);
        $exporter->save($localizedTranslations, $sheetName);
    }

    /**
     * @param $bookName
     * @return ResourceInterface
     * @throws \Exception
     */
    public function getResource()
    {
        if (null === $this->resource) {
            $this->resource = $this->buildResource();
        }

        return $this->resource;
    }

    /**
     * @return ResourceInterface $resource
     * @throws \Exception
     */
    private function buildResource()
    {
        /** @var ProviderInterface $provider */
        $providerFactory = new ProviderFactory();
        $providerConfiguration = new Configuration($this->configuration, 'provider');

        $provider = $providerFactory->create($providerConfiguration);
        return $provider->handleSourceResource();
    }

    public static function createFromConfiguration($configuration)
    {
        $class = get_called_class();
        return new $class($configuration);
    }
}