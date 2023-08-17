<?php
/**
 * Template Name: update-price
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package init
 */
 ini_set('display_errors', 0);
error_reporting(0);
if( !current_user_can('administrator') ){
    wp_redirect( '/login/' );
}

get_header();
page_header();

while ( have_posts() ) : the_post();
?> 
<style>
    .submit-update{

    box-sizing: border-box;
    font-family: var(--font);
    outline: none !important;
    height: var(--field);
    font-size: var(--fz);

    align-items: center;
    padding: 10px;
    border-radius: var(--rad-sm);
    border: 1px solid transparent;
    background: var(--theme);
    color: #fff;
    font-weight: 500;
    --btn-border: rgba(255,255,255,0.1);
    cursor: pointer;
    transition: 0.3s;
    position: relative;
    width: fit-content;
    --loading-color-1: rgba(255,255,255,0.2);
    --loading-color-2: #fff;
}
    
</style>
    <section class="dashboard section-padding pb">
        <div class="container">
            <div class="wrapper">
                <?php dashboard_sidebar(); ?>
                <div class="dashboard-content article">
                    <h2 class="instruction-update">Инструкция:</h2>
                    <div class="instruction-update-content">Данная форма принимает исключительно файлы с расширением ".xlsx".<br><br>Название файла должно включать себя город, для которого вы обновляете цену.<br> Пример правильного названия: "Город Москва"<br>Пример неправильного названия: "Город Москва(2)"<br><br>В excel файле каждый товар должен быть обозначен так же как и на сайте.<br> Пример неправильного названия товара: "Розы Эквадор".<br> Правильный пример: "Розы Эквадор кремовые".</div>
<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="xlsx_file">
    <input class="submit-update" type="submit" value="Загрузить">
</form>
                    <?php require_once './wp-content/themes/init/PHPExcel-1.8/Classes/PHPExcel.php';

function transliterate($input) {
    $replace=array(
		'"'=>'',
		'!' =>'',
		"«"=>"",
		"»"=>"",
		"ый"=>"yj",
		"№"=>"",
        "'"=>"",
        "`"=>"",
        "а"=>"a","А"=>"a",
        "б"=>"b","Б"=>"b",
        "в"=>"v","В"=>"v",
        "г"=>"g","Г"=>"g",
        "д"=>"d","Д"=>"d",
        "е"=>"e","Е"=>"e",
        "ё"=>"e","Ё"=>"e",
        "ж"=>"zh","Ж"=>"zh",
        "з"=>"z","З"=>"z",
        "и"=>"i","И"=>"i",
        "й"=>"j","Й"=>"j",
        "к"=>"k","К"=>"k",
        "л"=>"l","Л"=>"l",
        "м"=>"m","М"=>"m",
        "н"=>"n","Н"=>"n",
        "о"=>"o","О"=>"o",
        "п"=>"p","П"=>"p",
        "р"=>"r","Р"=>"r",
        "с"=>"s","С"=>"s",
        "т"=>"t","Т"=>"t",
        "у"=>"u","У"=>"u",
        "ф"=>"f","Ф"=>"f",
        "х"=>"h","Х"=>"h",
        "ц"=>"cz","Ц"=>"cz",
        "ч"=>"ch","Ч"=>"ch",
        "ш"=>"sh","Ш"=>"sh",
        "щ"=>"sch","Щ"=>"sch",
        "ь"=>"","Ь"=>"",
        "ы"=>"y","Ы"=>"y",
        "ъ"=>"","Ъ"=>"",
        "э"=>"e","Э"=>"e",
        "ю"=>"yu","Ю"=>"yu",
        "я"=>"ya","Я"=>"ya",
        "і"=>"i","І"=>"i",
        "ї"=>"yi","Ї"=>"yi",
        "є"=>"e","Є"=>"e"
    );

    return $str=iconv("UTF-8","UTF-8//IGNORE",strtr($input,$replace));
}
					function print_changes() {
    global $changes;
    echo '<table>';
    echo '<tr><th>Название товара</th><th>Название вариации</th><th style="text-align:start;">Цена</th></tr>';
    foreach ($changes as $productName => $variants) {
        foreach ($variants as $variantName => $price) {
            echo '<tr><td><a href="/product/'.$productName. '">' . $productName . '</td><td>' . $variantName . '</td><td>' . $price . '</td></tr>';
        }
    }
    echo '</table>';
}

function find_and_update_json($dataRow, $city) {
    $isChanged = false;
    global $changes;
    $city = str_replace("gorod", "", $city);
    $city = str_replace(' ', '', $city);
    $productName = transliterate($dataRow["Slug"]);
    $productName = str_replace(" ", "-", $productName);
    if(substr($productName, -1) == "-") {
        $productName = substr($productName, 0, -1);
    }
$productName = strtolower($productName);
    $filename = "./wp-content/themes/init/catalog/products/" . $productName . ".json";

    if (file_exists($filename)) {
		
        $jsonString = file_get_contents($filename);
        $data = json_decode($jsonString, true);

        foreach ($dataRow as $key => $value) {
            $key = trim($key);

            // Игнорировать ключи "одна цена " и "Название"
            if ($key == 'одна цена' || $key == 'Название') continue;

            if (!empty($data['variants'])) {
                foreach ($data['variants'] as $variantKey => $variantValue) {
                    // Проверить, совпадает ли ключ без "см" или с "см"
                    if (($key == $variantKey || $key . "см" == $variantKey) && !empty($value)) {
                        if (isset($data['variants'][$variantKey]['prices'][$city])) {
                            $data['variants'][$variantKey]['prices'][$city]['price'] = $value;
                            $isChanged = true;
                            $changes[$productName][$variantKey] = $value; // сохраняем изменение
                        } else {
                            // Если город не существует, добавляем его
                            $data['variants'][$variantKey]['prices'][$city] = array(
                                'price' => $value
                            );
                            $isChanged = true;
                            $changes[$productName][$variantKey] = $value; // сохраняем изменение
                        }
                    }
                }
            }

            if ($key === 'Цены' && !empty($value)) {
                if (isset($data['prices'][$city])) {
                    $data['prices'][$city]['price'] = (string)$value;
                    $isChanged = true;
                    $changes[$productName]['Цены'] = (string)$value; // сохраняем изменение
                } else {
                    // Если город не существует, добавляем его
                    $data['prices'][$city] = array(
                        'price' => (string)$value
                    );
                    $isChanged = true;
                    $changes[$productName]['Цены'] = (string)$value; // сохраняем изменение
                }
            }
        }

        $newJsonString = json_encode($data);
        file_put_contents($filename, $newJsonString);
    }

    return $isChanged;
}



$changes = array(); // инициализируем массив для сохранения изменений

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['xlsx_file'])) {
        $file = $_FILES['xlsx_file']['tmp_name'];
        $isChanged = false; 
        $city = transliterate(substr($_FILES['xlsx_file']['name'], 0, -5));

        $objPHPExcel = PHPExcel_IOFactory::load($file);
        $activeSheet = $objPHPExcel->getActiveSheet();

        $highestRow = $activeSheet->getHighestRow();
        $highestColumn = $activeSheet->getHighestColumn();
        $data = array();
        $columnNames = $activeSheet->rangeToArray('A1:' . $highestColumn . '1', null, true, false);

        for ($row = 2; $row <= $highestRow; $row++) {
            $rowData = $activeSheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false);
            $dataRow = array();

            foreach ($columnNames[0] as $columnKey => $columnName) {
               $dataRow[trim($columnName)] = trim($rowData[0][$columnKey]);

            }

            $data[] = $dataRow;
        }

        foreach ($data as $dataRow) {
             $isChanged = find_and_update_json($dataRow, $city) || $isChanged;
			


        }
        
        if ($isChanged) {
print_changes();
        } else {
            echo "Изменений не обнаружено.";
        }
    }
    else{
        echo 'Нет файла2';
    }
}

?>

 
                </div>
            </div>
        </div>
    </section>
<?php
endwhile;
get_footer();