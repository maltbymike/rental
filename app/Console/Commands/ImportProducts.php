<?php

namespace App\Console\Commands;

use Validator;

use App\Http\Requests\ProductRequest;

use App\Product;
use App\ProductCategory;
use App\ProductManufacturer;
use App\ProductRate;

use Illuminate\Console\Command;

class ImportProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products from stored chunked csv files';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      if ($path = glob(base_path('resources/pendingproducts/*.csv')))
      {

        $path = $path[0];

        $categories = ProductCategory::all();

        $data = $this->getDataFromCSV($path);

        $line = 1;
        foreach ($data as $row)
        {
          // Only process rental items
          $rental_types = ['T', 'V', 'U', 'K', 'D', 'H'];
          if (!in_array($row['type'], $rental_types))
          {
            continue;
          }

          $validated = $this->validateCSVRow($row, $line);

          // Update or Create product
          $product = Product::updateOrCreate(
            ['por_id' => $row['por_id']],
            [
              'product_key' => $row['product_key'],
              'name' => $row['name'],
              'quantity' => $row['quantity'],
              'type' => $row['type'],
              'part_number' => $row['part_number'],
              'model' => $row['model'],
              'header' => $row['header'],
              'inactive' => $row['inactive'],
              'hide_on_website' => $row['hide_on_website'],
              'weight' => $row['weight'],
              'slug' => str_slug($row['name'] . '-' . $row['product_key']),
            ]
          );

          // Get manufacturer_id and unset manufacturer
          if ($row['manufacturer'])
          {
            $manufacturer = ProductManufacturer::firstOrCreate(['name' => $row['manufacturer']]);
            $product->manufacturer()->associate($manufacturer);
            $product->save();
          }

          // create rates
          foreach ($row['rates'] as $rate)
          {
            if (!empty($rate['time']))
            {
              $data = [
                'hours' => $rate['time'],
                'rate' => $rate['rate']
              ];

              $updateRate = $product->rates()->where('hours', $data['hours'])->first() ?: new ProductRate($data);

              $updateRate->hours = $data['hours'];
              $updateRate->rate = $data['rate'];

              $product->rates()->save($updateRate);
            }
          }

          // Associate category
          if ($row['por_category'])
          {
            $category = ProductCategory::firstOrCreate(
              ['por_id' => $row['por_category']],
              [
                'name' => 'Category Added From CSV Import',
                'slug' => $row['por_category'],
              ]
            );
            $product->categories()->syncWithoutDetaching($category);
            $product->save();
          }

          $line++;
        }
        $line--;
        echo "Successfully imported $line items";

        unlink($path);
      }
    }

    public function getDBFields()
    {
      return [
        'KEY' => 'product_key',
        'PartNumber' => 'part_number',
        'NUM' => 'por_id',
        'NAME' => 'name',
        'QTY' => 'quantity',
        'TYPE' => 'type',
        'MANF' => 'manufacturer',
        'MODN' => 'model',
        'Header' => 'header',
        'Inactive' => 'inactive',
        'HideOnWebsite' => 'hide_on_website',
        'Weight' => 'weight',
        'Category' => 'por_category',
        'PER1' => 'PER|1',
        'PER2' => 'PER|2',
        'PER3' => 'PER|3',
        'PER4' => 'PER|4',
        'PER5' => 'PER|5',
        'PER6' => 'PER|6',
        'PER7' => 'PER|7',
        'PER8' => 'PER|8',
        'RATE1' => 'RATE|1',
        'RATE2' => 'RATE|2',
        'RATE3' => 'RATE|3',
        'RATE4' => 'RATE|4',
        'RATE5' => 'RATE|5',
        'RATE6' => 'RATE|6',
        'RATE7' => 'RATE|7',
        'RATE8' => 'RATE|8',
      ];
    }

    public function getDataFromCSV($filename)
    {
      $data = $header = [];
      $i = 0;
      $fields = $this->getDBFields();

      $file = @fopen($filename, 'r');
      if ($file)
      {
        while(($row = fgetcsv($file)) !== false)
        {
          if (empty($header))
          {
            $header = $row;
            continue;
          }

          foreach ($row as $key => $value)
          {
            if (isset($fields[$header[$key]]))
            {
              if (substr($fields[$header[$key]], 0, 3) == "PER")
              {
                $getRateNumber = explode("|", $fields[$header[$key]]);
                $data[$i]['rates'][$getRateNumber[1]]['time'] = $value;
              }
              elseif (substr($fields[$header[$key]], 0, 4) == 'RATE')
              {
                $getRateNumber = explode("|", $fields[$header[$key]]);
                $data[$i]['rates'][$getRateNumber[1]]['rate'] = $value;
              }
              else
              {
                if ($value == "True")
                {
                  $value = 1;
                }
                elseif ($value == 'False')
                {
                  $value = 0;
                }
                $data[$i][$fields[$header[$key]]] = $value;
              }
            }
          }

          $i++;
        }
      }
      return $data;
    }

    public function validateCSVRow($row, $line)
    {
      $csv_errors = Validator::make(
        $row,
        (new ProductRequest)->rules()
      )->errors();

      if ($csv_errors->any())
      {
        return redirect()->back()
          ->withErrors($csv_errors)
          ->with('error_line', $line);
      }

      return $row;
    }
}
