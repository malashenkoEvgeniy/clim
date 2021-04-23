<?php

namespace App\Components\Parsers\PromUa;

use App\Components\Parsers\AbstractParsedCategory;
use App\Components\Parsers\AbstractParser;
use App\Exceptions\WrongParametersException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

/**
 * Class Parser
 *
 * @package App\Components\Parsers\PromUa
 */
class Parser extends AbstractParser
{
    /**
     * @var array
     */
    static $availableFormats = ['xls', 'xlsx'];
    
    /**
     * @var string
     */
    protected $pathToFile;
    
    /**
     * Import constructor.
     *
     * @param string $pathToFile
     */
    public function __construct(string $pathToFile)
    {
        $this->categories = new Collection();
        $this->products = new Collection();
        $this->pathToFile = $pathToFile = storage_path('app/public/' . $pathToFile);
    }
    
    /**
     * @return AbstractParsedCategory
     */
    public function createEmptyParsedCategoryObject(): AbstractParsedCategory
    {
        return new ParsedCategory();
    }
    
    /**
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \Exception|\Throwable
     */
    public function start(): void
    {
        $filePathParts = explode('/', $this->pathToFile);
        $fileName = end($filePathParts);
        $file = new UploadedFile($this->pathToFile, $fileName);
        $extension = $file->getClientOriginalExtension();
        $errors = $this->validate($file, $extension);
        if (count($errors) > 0) {
            throw new WrongParametersException(array_first($errors));
        }
        // Parse file for import
        $inputFileType = ucfirst($extension);
        $reader = IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($this->pathToFile);
        // Parse categories
        $this->parseCategories($spreadsheet);
        // Parse products
        $this->parseProducts($spreadsheet);
        @unlink($this->pathToFile);
    }
    
    /**
     * @param UploadedFile $file
     * @param string|null $extension
     * @return array
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public static function validate(UploadedFile $file, ?string $extension = null): array
    {
        $extension = $extension ?? $file->getClientOriginalExtension();
        // Check extensions
        if (in_array($extension, static::$availableFormats) === false) {
            return ['Wrong import file mime!'];
        }
        $inputFileType = ucfirst($extension);
        $reader = IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($file->path());
        // Check spreadsheets count
        if ($spreadsheet->getSheetCount() < 2) {
            return ['Count of spreadsheets needs to be gte to 2! In your file - ' . $spreadsheet->getSheetCount()];
        }
        // Check products spreadsheet first line
        $line = $spreadsheet->getSheet(0)->getRowIterator()->current();
        $columns = [];
        foreach ($line->getCellIterator() as $cell) {
            $columns[$cell->getColumn()] = $cell->getValue();
        }
        if ($diff = array_diff(ParsedProduct::$requiredColumns, $columns)) {
            return ['You do not have required columns in your products list: ' . implode(', ', $diff)];
        }
        // Check categories spreadsheet first line
        $line = $spreadsheet->getSheet(1)->getRowIterator()->current();
        $columns = [];
        foreach ($line->getCellIterator() as $cell) {
            $columns[$cell->getColumn()] = $cell->getValue();
        }
        if ($diff = array_diff(ParsedCategory::$requiredColumns, $columns)) {
            return ['You do not have required columns in your categories list: ' . implode(', ', $diff)];
        }
        // All ok
        return [];
    }
    
    /**
     * @param Spreadsheet $spreadsheet
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \Throwable
     */
    private function parseCategories(Spreadsheet $spreadsheet): void
    {
        $columns = [];
        foreach ($spreadsheet->getSheet(1)->getRowIterator() as $row) {
            if ($row->getRowIndex() === 1) {
                foreach ($row->getCellIterator() as $cell) {
                    $columns[$cell->getColumn()] = $cell->getValue();
                }
                continue;
            }
            // Parse category row
            $parsedCategory = new ParsedCategory();
            $parsedCategory->setCellIterator($row->getCellIterator())->setColumns($columns)->parse();
            // Push to categories list
            $this->categories->push($parsedCategory);
        }
    }
    
    /**
     * @param Spreadsheet $spreadsheet
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \Throwable
     */
    private function parseProducts(Spreadsheet $spreadsheet): void
    {
        $columns = [];
        foreach ($spreadsheet->getSheet(0)->getRowIterator() as $row) {
            if ($row->getRowIndex() === 1) {
                foreach ($row->getCellIterator() as $cell) {
                    $columns[$cell->getColumn()] = $cell->getValue();
                }
                continue;
            }
            // Parse product row
            $parsedProduct = new ParsedProduct();
            $parsedProduct->setCellIterator($row->getCellIterator())->setColumns($columns)->parse();
            if (!$parsedProduct->currency) {
                $parsedProduct->currency = 'UAH';
            }
            if (!$parsedProduct->productUrl) {
                $parsedProduct->setAttribute('Продукт_на_сайте', 'https://prom.ua/' . Str::slug($parsedProduct->name));
            }
            if (!$parsedProduct->price) {
                $parsedProduct->price = 0;
            }
            // Push to products list
            $this->products->push($parsedProduct);
        }
    }
    
}
