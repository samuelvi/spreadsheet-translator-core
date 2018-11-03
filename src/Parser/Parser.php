<?php

/*
 * This file is part of the Atico/SpreadsheetTranslator package.
 *
 * (c) Samuel Vicent <samuelvicent@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Atico\SpreadsheetTranslator\Core\Parser;

use Atico\SpreadsheetTranslator\Core\Configuration\Configuration;
use Atico\SpreadsheetTranslator\Core\Exception\NoDataToParseException;
use Atico\SpreadsheetTranslator\Core\Reader\ReaderFactory;
use Atico\SpreadsheetTranslator\Core\Resource\ResourceInterface;

class Parser
{
    /** @var ParserConfigurationManager $configuration */
    protected $configuration;

    protected $reader;

    public function __construct(ResourceInterface $resource, Configuration $configuration)
    {
        $this->configuration = new ParserConfigurationManager($configuration);

        $readerFactory = new ReaderFactory();
        $this->reader = $readerFactory->create($resource->getValue(), $resource->getFormat());
    }

    /**
     * @throws NoDataToParseException
     */
    public function parseSheet($sheetName)
    {
        $data = $this->reader->getDataBySheetName($sheetName);

        /** @var DataParser $dataParser */
        $dataParser = new DataParser($data,
            $this->configuration->getRowHeader(),
            $this->configuration->getFirstRow(),
            $this->configuration->getNameSeparator()
        );

        if (!$dataParser->hasDataToParse()) {
            throw NoDataToParseException::create();
        }

        $locales = $dataParser->getLocales();
        if ($this->configuration->getLazyMode()) {
            $translations = $this->doParseSheet($dataParser, $locales);
        } else {
            $translations = $this->doParseSheetConsideringLazyKeys($dataParser, $locales);
        }

        return $translations;
    }

    private function doParseSheet($dataParser, $locales)
    {
        /** @var DataParser $row */
        foreach ($dataParser as $row) {

            $key = $row->resolveKey();

            foreach ($locales as $locale) {

                $value = $row->getValue($locale);

                if (!empty($value)) {
                    $translations[$locale][$key] = $value;
                }
            }
        }

        return $translations;
    }

    /**
     * @param \IteratorIterator $dataParser
     * @return mixed
     */
    private function doParseSheetConsideringLazyKeys(DataParser $dataParser, $locales)
    {
        $previousKeys = [];
        foreach ($dataParser as $row) {

            $previousKeys = $row->resolveLazyKeys($previousKeys);

            if (empty($key = $row->buildKey($previousKeys))) {
                continue;
            }

            foreach ($locales as $locale) {

                if (!empty($value = $row->getValue($locale))) {
                    $translations[$locale][$key] = $value;
                }
            }
        }

        return $translations;
    }
}