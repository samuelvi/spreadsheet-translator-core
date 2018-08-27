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
use Atico\SpreadsheetTranslator\Core\Exception\NoDataToParse;
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
     * @throws NoDataToParse
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
            throw NoDataToParse::create();
        }

        $translations = [];
        $locales = $dataParser->getLocales();

        $includeEmpty = $this->configuration->getIncludeEmpty();

        /** @var DataParser $row */
        foreach ($dataParser as $row) {

            foreach ($locales as $locale) {
                $key = $row->getKey();
                $value = $row->getValue($locale);

                if (!empty($value) || $includeEmpty) {
                    $translations[$locale][$key] = $value;
                }
            }
        }
        return $translations;
    }
}