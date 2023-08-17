<?php

// Функция внесения заявок в базу
function get_request(
    $fields,    // массив с полями
    $db_name,   // название базы данных
    $status,    // статус
    $data,      // массив с данными
    $message    // массив с данными
){

    if( isset( $data ) ){

        // Массив с данными полей, новые поля вносить сюда
        $fields_data = array(
            'date' => array(
                'type'      => 'date',  // Тип данных
                'format'    => '%s',    // Формат, string или число,
                'label'     => 'Дата',  // Название поля для письма
                'filter'    => 'text'    // Название фильтра для поля
            ),
            'user_id' => array(
                'type'      => 'user_id',
                'format'    => '%d',
                'label'     => 'ID',
                'filter'    => 'text'
            ),
            'name' => array(
                'type'      => 'variable',
                'format'    => '%s',
                'label'     => 'Имя',
                'filter'    => 'text'
            ),
            'phone' => array(
                'type'      => 'variable',
                'format'    => '%s',
                'label'     => 'Телефон',
                'filter'    => 'phone'
            ),
            'email' => array(
                'type'      => 'variable',
                'format'    => '%s',
                'label'     => 'Email',
                'filter'    => 'text'
            ),
            'message' => array(
                'type'      => 'variable',
                'format'    => '%s',
                'label'     => 'Сообщение',
                'filter'    => 'text'
            ),
            'comment' => array(
                'type'      => 'variable',
                'format'    => '%s',
                'label'     => 'Комментарий',
                'filter'    => 'text'
            ),
            'method' => array(
                'type'      => 'variable',
                'format'    => '%d',
                'label'     => 'Метод',
                'filter'    => 'method'
            ),
            'services' => array(
                'type'      => 'encode',
                'format'    => '%s',
                'label'     => 'Услуги',
                'filter'    => 'text'
            ),
            'delivery' => array(
                'type'      => 'variable',
                'format'    => '%d',
                'label'     => 'Доставка',
                'filter'    => 'text'
            ),
            'info_user' => array(
                'type'      => 'encode',
                'format'    => '%s',
                'label'     => 'О пользователе',
                'filter'    => 'text'
            ),
            'info_product' => array(
                'type'      => 'encode',
                'format'    => '%s',
                'label'     => 'Информация',
                'filter'    => 'text'
            ),
            'quantity' => array(
                'type'      => 'variable',
                'format'    => '%d',
                'label'     => 'Количество',
                'filter'    => 'text'
            ),
            'price' => array(
                'type'      => 'calc_products',
                'format'    => '%d',
                'label'     => 'Итоговая цена',
                'filter'    => 'text'
            ),
            'status' => array(
                'type'      => 'variable',
                'format'    => '%d',
                'label'     => 'Статус',
                'filter'    => 'status'
            )
        );

        global $wpdb;

        // Массив для обработанных данных
        $request = array();

        // Массив для форматов
        $request_format = array();

        // Перебор полей
        foreach($fields as $field_name){

            if(isset($data[$field_name]) || $field_name == 'status'){
                // Данные поля
                $field_data = $fields_data[$field_name];
                // Тип поля
                $type = $field_data['type'];
                // Формат поля
                $format = $field_data['format'];
                // Переменная с результатом
                $result;

                // Обработка типа 'variable'
                if($type == 'variable'){

                    if($field_name == 'status'){
                        $result = $status;
                    }else{
                        $result = $data[$field_name];
                    }
                
                // Обработка типа 'encode'
                }else if($type == 'encode'){
                    if($data[$field_name]){
                        $result = json_encode( $data[$field_name], JSON_UNESCAPED_UNICODE);
                    }else{
                        $result = '';
                    }

                // Обработка типа 'decode'
                }else if($type == 'decode'){
                    $result = json_decode( $data[$field_name]);

                // Обработка типа 'date'
                }else if($type == 'date'){

                    if(isset($data[$field_name])){
                        $result = $data[$field_name];
                    }else{
                        date_default_timezone_set('Asia/Almaty');
                        $result = date("Y-m-d H:i:s");
                    }

                // Обработка типа 'calc_products'
                }else if($type == 'calc_products'){

                    if(isset($data['products'])){

                        foreach ($data['products'] as $key => $value) {

                            $value = (int)$value;
                
                            // Получаем цену всех товаров * на их колличество
                            $result += (int)get_field('price', $key) * $value;

                            if( isset($data['delivery_price']) ){
                                $result += $data['delivery_price'];
                            }
                            
                        }

                    }

                // Обработка типа 'user_id'
                }else if($field_name == 'user_id'){
                    $result = get_current_user_id();
                }

                // Внесение в массив
                $request[$field_name] = $result;
                $request_format[] = $format;
            }

        }

        // Внесение в массив
        $add_to_db = $wpdb->insert($db_name, $request, $request_format);

        // Проверка внесения в базу
        if($add_to_db){
            echo json_encode(array('result' => 'success'));

            $filters = array(
                'text' => function($value){
                    return $value;
                },
                'phone' => function($value){
                    return '<span style="color: #ef3a4b;">' . $value . '</span>';
                },
                'link' => function($value){
                    return '<a href="' . $value . '" style="text-decoration: none; color: #7289DA;">' . $value . '</a>';
                },
                'method' => function($value){
                    $methods = array('Консультация', 'Заявка', 'Сообщение');
                    return $methods[$value];
                },
            );

            if($message){
                $title = $message[0];
                $fields = $message[1];

                $structure = '
                <div class="content">

                <div style="background-color:#F9F9F9;font-family:Whitney, Helvetica Neue, Helvetica, Arial, Lucida Grande, sans-serif;">
            
                    <div style="margin:0px auto;max-width:640px;">
            
                        <table style="width:100%;">
                            <tbody>
            
                                <tr>
                                    <td style="padding:28px 0px;text-align:center;">
                                        <a href="https://school.init.kz/" style=" color: #ef3a4b; font-family: \'Open Sans\', sans-serif; font-weight: 600; font-size: 24px; text-decoration: none;" target="_blank"><span style="color: #000;">school</span>.init</a>
                                    </td>
                                </tr>
            
                                <tr style="background:#ffffff;">
                                    <td style="padding:28px;">
                                        <table style="width: 100%">
                                            <tbody style="color:#737F8D;font-size:16px;line-height:24px;">
                                                <tr>
                                                    <td colspan="2">
                                                        <h2 style="font-weight: bold;font-size: 24px;color: #000;border-bottom: 1px solid rgba(0, 0, 0, 0.2);padding-bottom: 20px;">' . $title . '</h2>
                                                    </td>
                                                </tr>';

                foreach($fields as $item){
                    $label = $fields_data[$item]['label'];
                    $filter = $fields_data[$item]['filter'];
    
                    if($request[$item]){
                        $structure .= '
                            <tr>
                                <td style="color: #000;">' . $label . ':</td>
                                <td>' . $filters[$filter]($request[$item]) . '</td>
                            </tr>
                        ';
                    }
                }
                $structure .= '
                                            </tbody>
                                            </table>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="vertical-align:top;padding:20px 0px;">
                                            <div style="color:#99AAB5;font-size:12px;line-height:24px;text-align:center;"> Онлайн школа веб-разработки <a href="https://school.init.kz/" style="text-decoration: none; color: #7289DA;" target="_blank">school.init.kz</a></div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>

                        </div>

                    </div>

                </div>
                ';

                // $order_option   = get_field('order', 'option');
                // $order_header   = $order_option['header'];
                // $order_email    = $order_option['email'];

                $headers = array( 
                    "content-type: text/html"
                );

                wp_mail(TO_EMAIL, $title, $structure, $headers);
            }

        }else{
            echo json_encode(array('result' => 'error'));
        }

    };

    die();

}

// Функция обновления количества заявок
function refresh_count(){
    
    $page_name = $_POST['page_name'];

    global $wpdb;

    $new_count = $wpdb->get_var( "SELECT COUNT(*) FROM `init_$page_name` WHERE `status` = 0" );
    $processed_count = $wpdb->get_var( "SELECT COUNT(*) FROM `init_$page_name` WHERE `status` = 1" );
    $deleted_count = $wpdb->get_var( "SELECT COUNT(*) FROM `init_$page_name` WHERE `status` = 2" );
    $total_count = $wpdb->get_var( "SELECT COUNT(*) FROM `init_$page_name`" );

    $total_array = array(
        'new'       => $new_count,
        'processed' => $processed_count,
        'deleted'   => $deleted_count,
        'total'     => $total_count
    );

    $json = json_encode($total_array);

    echo $json;

    die();
}
add_action( 'wp_ajax_refresh_count', 'refresh_count' );
add_action( 'wp_ajax_nopriv_refresh_count', 'refresh_count' );

// Функция вывода страницы
function page_output( 
    $page_name,     // Название страницы
    $settings,      // Массив с настройками
    $labels,        // Массив с названием полей
    $status         // Статус
){

    if( isset( $_GET['status'] ) ){
        $status = $_GET['status'];
    }


    global $wpdb;

    // Количество заявок
    $new_count = $wpdb->get_var( "SELECT COUNT(*) FROM `init_$page_name` WHERE `status` = 0" );
    $processed_count = $wpdb->get_var( "SELECT COUNT(*) FROM `init_$page_name` WHERE `status` = 1" );
    $deleted_count = $wpdb->get_var( "SELECT COUNT(*) FROM `init_$page_name` WHERE `status` = 2" );
    $total_count = $wpdb->get_var( "SELECT COUNT(*) FROM `init_$page_name`" );

    $empty_labels = array(
        'orders'  => 'заявок',
        'reviews' => 'отзывов',
        'mail'    => 'писем'
    );

    // Параметры полей
    $labels_info = array(
        'id' => array(
            'label'	   => '#ID',    // label поля
            'width'	   => 60,       // Ширина поля
            'sortable' => 1         // Можно сортировать
        ), 
        'name'    => array(
            'label'	   => 'Имя',
            'width'	   => 220,
            'sortable' => 1
        ),
        'rating'       => array(
            'label'	   => 'Рейтинг',
            'width'	   => 160,
            'sortable' => 1
        ),
        'review'       => array(
            'label'	   => 'Отзыв',
            'width'	   => 'grow',
            'sortable' => 0
        ),
        'phone'        => array(
            'label'	   => 'Номер телефона',
            'width'	   => 'grow',
            'sortable' => 0
        ),
        'comment'      => array(
            'label'	   => 'Комментарии',
            'width'	   => 'grow',
            'sortable' => 0
        ),
        'email'        => array(
            'label'	   => 'Email',
            'width'	   => 'grow',
            'sortable' => 0
        ),
        'method'      => array(
            'label'	   => 'Метод',
            'width'	   => 220,
            'sortable' => 1
        ),
        'services'      => array(
            'label'	   => 'Услуги',
            'width'	   => 300,
            'sortable' => 1
        ),
        'quantity'     => array(
            'label'	   => 'Количество',
            'width'	   => 160,
            'sortable' => 1
        ),
        'delivery'     => array(
            'label'	   => 'Тип',
            'width'	   => is_admin() ? 160 : 230,
            'sortable' => 1
        ),
        'price'  => array(
            'label'	   => 'Итого',
            'width'	   => 120,
            'sortable' => 1
        ),
        'date'         => array(
            'label'	   => 'Дата и время',
            'width'	   => 150,
            'sortable' => 1
        ),
        'action'       => array(
            'label'	   => 'Действие',
            'width'	   => 124,
            'sortable' => 0
        )
    )
    ?>

    <div class="wrap" data-name="<?php echo $page_name; ?>">
        
        <?php if(is_admin()){ ?>
        <h2><?php echo get_admin_page_title() ?></h2>
        <?php } ?>

        <div class="tabs">

            <?php if( $settings['sidebar'] ){ ?>
                <div class="tab-sidebar">
                    
                </div>
            <?php } ?>

            <div class="tab-content">

                <div class="tab-item active">

                    <?php alert(); ?>

                    <div class="block-item">

                    <?php preloader(); ?>

                        <div class="blocking"></div>

                        <div class="block-title">
                            <h3><?php echo $settings['block_title']; ?></h3>
                            <div class="count"><?php echo '<span>' . $total_count . '</span>' . ' ' . $empty_labels[$page_name]; ?></div>
                        </div>
                        
                        <div class="block-content">

                            <div class="history-body">

                                <div class="table-header">

                                    <div class="top">
                                        <button class="button check-all grey">Выделить все</button>
                                        <?php if( $status == 0 ){ ?>
                                            <button name="<?php echo $page_name; ?>_process" class="button process-btn process-selected" disabled>Обработать</button>
                                        <?php }; 
                                        
                                        if($status == 2){?>
                                            <button name="<?php echo $page_name; ?>_recover" class="button recover-btn recover-selected" disabled>Восстановить</button>
                                            <button name="<?php echo $page_name; ?>_trash_delete" class="button delete-btn grey del-selected" disabled>Удалить с корзины</button>
                                        <?php }else{ ?>
                                            <button name="<?php echo $page_name; ?>_delete" class="button delete-btn grey del-selected" disabled>Удалить</button>
                                        <?php } ?>
                                        <ul class="subsubsub">
                                            <li class="new">
                                                <a href="<?php echo is_admin() ? "/wp-admin/admin.php?page=$page_name" : "/dashboard/$page_name/"; ?>" <?php echo $status == 0 ? "class='active'" : ""; ?>>Новые <span class="count">(<?php echo $new_count; ?>)</span></a>
                                            </li>
                                            <li class="processed">
                                                <a href="<?php echo is_admin() ? "/wp-admin/admin.php?page=$page_name-processed" : "/dashboard/$page_name/?status=1"; ?>" <?php echo $status == 1 ? "class='active'" : ""; ?>>Все обработанные <span class="count">(<?php echo $processed_count; ?>)</span></a>
                                            </li>
                                            <li class="deleted">
                                                <a href="<?php echo is_admin() ? "/wp-admin/admin.php?page=$page_name-deleted" : "/dashboard/$page_name/?status=2"; ?>" <?php echo $status == 2 ? "class='active'" : ""; ?>>Удаленные <span class="count">(<?php echo $deleted_count; ?>)</span></a>
                                            </li>
                                        </ul>                                    
                                    </div>
                                    <?php if($settings['filters'] == 1){ ?>

                                        <div class="middle">
                                            <div class="form-group no-label small">
                                                <label for="id-filter-top"><span>#</span></label>
                                                <input type="text" class="id-mask with-partner build-filter" id="id-filter-top" data-partner="id-filter-bottom" placeholder="ID">
                                            </div>
                                            <div class="form-group no-label">
                                                <label for="select-range-top"><span class="icon-calendar"></span></label>
                                                <input type="text" id="select-range-top" class="select-range with-partner" data-partner="select-range-bottom" placeholder="Выберите период">
                                            </div>
                                            <div class="form-group no-label big">
                                                <label for="search-user-filter-top"><span class="icon-search"></span></label>
                                                <div class="select-wrapper" data-max="1">
                                                    <input type="text" id="search-user-filter-top" class="search-user-filter with-partner" data-partner="search-user-filter-bottom" placeholder="Имя пользователя">
                                                </div>
                                            </div>
                                            <div class="form-group no-label">
                                                <label for="search-city-filter-top"><span class="icon-search"></span></label>
                                                <div class="select-wrapper" data-max="1">
                                                    <input type="text" id="search-city-filter-top" class="search-city-filter with-partner" data-partner="search-city-filter-bottom" placeholder="Город">
                                                </div>
                                            </div>
                                            <div class="form-group no-label big">
                                                <label for="type-filter-top"><span class="icon-search"></span></label>
                                                <div class="select-wrapper" data-max="1">
                                                    <input type="text" id="type-filter-top" class="type-filter with-partner" data-partner="type-filter-bottom" placeholder="Тип">
                                                </div>
                                            </div>
                                            <div class="form-group no-label small">
                                                <label for="sum-filter-top"><span><?php echo CUR ?></span></label>
                                                <input type="text" class="sum-mask with-partner build-filter" id="sum-filter-top" data-partner="sum-filter-bottom" placeholder="Сумма">
                                            </div>
                                            <div class="form-group no-label">
                                                <label for="status-filter-top"><span class="icon-down"></span></label>
                                                <div class="select-wrapper" data-max="1">
                                                    <input type="text" class="select status-filter with-partner" id="status-filter-top" data-partner="status-filter-bottom" placeholder="Статус">
                                                </div>
                                            </div>
                                        </div>

                                    <?php }; ?>

                                    <div class="bottom labels-wrapper">
                                        <?php
                                            $items_width = array();
                                            foreach($labels as $label){ 
                                                $items_width[$label] = $labels_info[$label]['width'];
                                                $info = $labels_info[$label];
                                            ?>
                                                <div data-width="<?php echo $info['width']; ?>" data-name="<?php echo $label; ?>" class="<?php echo $label; echo $info['sortable'] == 1 ? ' sortable icon-up' : ''; echo $label == 'id' ? ' decrease active' : ''; ?>" style="<?php echo $info['width'] == 'grow' ? 'flex-grow: 1;' : "width: {$info['width']}px;"; ?>"><?php echo $info['label'] ?></div>
                                            <?php }										
                                        ?>
                                    </div>

                                </div>

                                <div class="table-content">

                                    <?php preloader(); ?>

                                    <div class="content"></div>

                                </div>

                                <div class="table-footer">
                                    <?php if($settings['filters'] == 1){ ?>
                                        <div class="top">
                                            <div class="form-group no-label small">
                                                <label for="id-filter-bottom"><span>#</span></label>
                                                <input type="text" class="id-mask with-partner build-filter" id="id-filter-bottom" data-partner="id-filter-top" placeholder="ID">
                                            </div>
                                            <div class="form-group no-label">
                                                <label for="select-range-bottom"><span class="icon-calendar"></span></label>
                                                <input type="text" id="select-range-bottom" class="select-range with-partner" data-partner="select-range-top" placeholder="Выберите период">
                                            </div>
                                            <div class="form-group no-label big">
                                                <label for="search-user-filter-bottom"><span class="icon-search"></span></label>
                                                <div class="select-wrapper" data-max="1">
                                                    <input type="text" id="search-user-filter-bottom" class="search-user-filter with-partner" data-partner="search-user-filter-top" placeholder="Имя пользователя">
                                                </div>
                                            </div>
                                            <div class="form-group no-label">
                                                <label for="search-city-filter-bottom"><span class="icon-search"></span></label>
                                                <div class="select-wrapper" data-max="1">
                                                    <input type="text" id="search-city-filter-bottom" class="search-city-filter with-partner" data-partner="search-city-filter-top" placeholder="Город">
                                                </div>
                                            </div>
                                            <div class="form-group no-label big">
                                                <label for="type-filter-bottom"><span class="icon-search"></span></label>
                                                <div class="select-wrapper" data-max="1">
                                                    <input type="text" id="type-filter-bottom" class="type-filter with-partner" data-partner="type-filter-top" placeholder="Тип">
                                                </div>
                                            </div>
                                            <div class="form-group no-label small">
                                                <label for="sum-filter-bottom"><span><?php echo CUR ?></span></label>
                                                <input type="text" class="sum-mask with-partner build-filter" id="sum-filter-bottom" data-partner="sum-filter-top" placeholder="Сумма">
                                            </div>
                                            <div class="form-group no-label">
                                                <label for="status-filter-bottom"><span class="icon-down"></span></label>
                                                <div class="select-wrapper" data-max="1">
                                                    <input type="text" class="select status-filter with-partner" id="status-filter-bottom" data-partner="status-filter-top" placeholder="Статус">
                                                </div>
                                            </div>
                                        </div>
                                    <?php }; ?>
                                    <div class="middle">
                                        <?php if( $status == 0 ){ ?>
                                            <button name="<?php echo $page_name; ?>_process" class="button process-btn process-selected" disabled>Обработать</button>
                                        <?php }; 
                                        
                                        if($status == 2){?>
                                            <button name="<?php echo $page_name; ?>_recover" class="button recover-btn recover-selected" disabled>Восстановить</button>
                                            <button name="<?php echo $page_name; ?>_trash_delete" class="button delete-btn grey del-selected" disabled>Удалить с корзины</button>
                                        <?php }else{ ?>
                                            <button name="<?php echo $page_name; ?>_delete" class="button delete-btn grey del-selected" disabled>Удалить</button>
                                        <?php } ?>
                                    </div>
                                </div>
                                
                                <?php /*
                                <div class="pagination-block">
                                    <div class="form-group no-label">
                                        <label for="items-per-page">Количество<span class="icon-down"></span></label>
                                        <input type="text" data-id="0" class="select" id="items-per-page" placeholder="Количество строк" readonly value="25">
                                        <ul class="dropdown">
                                            <li data-id="0">25</li>
                                            <li data-id="1">50</li>
                                            <li data-id="2">100</li>
                                            <li data-id="3">200</li>
                                        </ul>
                                    </div>
                                </div>
                                */ ?>
                            </div>
                            
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>

    <?php 
}

// Функция вывода item'ов
function output_items(){

    global $wpdb;

    $items_width = $_POST['items_width'];

    $page_name = $_POST['page_name'];
    $status = $_POST['status'];
    $items_count = $wpdb->get_var( "SELECT COUNT(*) FROM `init_$page_name` WHERE `status` = $status" );
    $refresh = $_POST['refresh'];

    $count = $_POST['count'];

    if($_POST['items_count'] == $items_count && $refresh == 0 && $items_count != 0){
        die();
    }

    // Сортировка
    $sort = $_POST['sort'];
    $sort_name = $sort['name'];
    $sort_direction = $sort['direction'];

    $hide_empty = $_POST['empty'];
    $results = $wpdb->get_results( "SELECT * FROM `init_$page_name` WHERE `status` = '$status' ORDER BY `$sort_name` {$sort_direction} LIMIT 0, {$count}" );

    $empty_labels = array(
        'orders'  => array('Заявка обработана', 'заявок', 'Заявка', 'Заявка удалена', 'Заявка восстановлена'),
        'reviews' => array('Отзыв обработан', 'отзывов', 'Отзыв', 'Отзыв удален', 'Отзыв восстановлен'),
        'mail'    => array('Письмо обработано', 'писем', 'Письмо', 'Письмо удалено', 'Письмо восстановлено')
    );

    $empty = $empty_labels[$page_name];

    
    if( !empty( $results ) ){

        $content_type = array(
            'id' => function($array, $width, $page_name){ ?>
                <div class="id" style="<?php echo $width == 'grow' ? 'flex-grow: 1;' : "width: {$width}px;"; ?>">#<?php echo $array->id; ?></div>
            <?php },
            
            'name' => function($array, $width, $page_name){
                $name = $array->name;

                if($name == ''){
                    $name = 'Пользователь';
                }

                $name = trim($name);

                mb_internal_encoding('UTF-8');
                ?>
                <div class="name field-wrapper prevent-open" style="<?php echo $width == 'grow' ? 'flex-grow: 1;' : "width: {$width}px;"; ?>">
                    <div class='avatar'><?php echo mb_substr($name, 0, 1); ?></div>
                    <input type="text" value="<?php echo $name; ?>" class="current_username change-field" data-field="name" data-def="Пользователь" data-id="<?php echo $array->id; ?>" placeholder="Введите имя">
                    <div class="accert-change">
                        <div class="yes icon-check"></div>
                        <div class="no icon-close"></div>
                    </div>
                </div>
            <?php },

            'email' => function($array, $width, $page_name){ ?>
                <div class="user_email" style="<?php echo $width == 'grow' ? 'flex-grow: 1;' : "width: {$width}px;"; ?>"><?php echo $array->email; ?></div>
            <?php },

            'phone' => function($array, $width, $page_name){ 
                if(isset($array->info_user)){
                    $info = json_decode($array->info_user);
                    $phone = $info->phoneNumber;
                    if($info->additionalPhoneNumber){
                        $phone .= '<br>' . $info->additionalPhoneNumber;
                    }
                }else if(isset($array->user_phone)){
                    $phone = $array->user_phone;
                }else{
                    $phone = $array->phone;
                }
            ?>
                <div class="user_phone prevent-open" style="<?php echo $width == 'grow' ? 'flex-grow: 1;' : "width: {$width}px;"; ?>"><a class="phone" href="tel:+<?php echo $phone; ?>"><?php echo $phone; ?></a></div>
            <?php },

            'comment' => function($array, $width, $page_name){
                ?>
                <div class="comment prevent-open field-wrapper" style="<?php echo $width == 'grow' ? 'flex-grow: 1;' : "width: {$width}px;"; ?>">
                    <textarea name="comment" class="item_comment change-field resizable" oninput="textAreaAdjust(this)" max-height="100" data-field="comment" data-id="<?php echo $array->id; ?>" rows="1" placeholder="Введите комментарии"><?php echo $array->comment; ?></textarea>
                    <div class="accert-change">
                        <div class="yes icon-check"></div>
                        <div class="no icon-close"></div>
                    </div>
                </div>
                <?php
            },

            'delivery' => function($array, $width, $page_name){
                $info = json_decode($array->info_user); 
                $delivery_price = $info->deliveryPrice;
                $delivery = $array->delivery == 0 ? 'Доставка' : 'Самовызов';
                $method = $array->method;
            ?>
                <div class="delivery" style="<?php echo $width == 'grow' ? 'flex-grow: 1;' : "width: {$width}px;"; ?>">
                    <?php echo $delivery; echo $array->delivery == 0 ? ' ' . $delivery_price . ' ' . CUR : ''; ?>
                    <div class="more-info">
                        <?php
                            if($method == 0){
                                echo "Наличные ";
                                echo $info->getChange ? "( Сдача: " . $info->getChange . " " . CUR . " )" : "";
                            }elseif($method == 1){
                                echo "Kaspi перевод";
                            }
                        ?>
                    </div>
                </div>
            <?php },

            'method' => function($array, $width, $page_name){
                $method = $array->method;
            ?>
                <div class="method" style="<?php echo $width == 'grow' ? 'flex-grow: 1;' : "width: {$width}px;"; ?>">
                    <?php
                        if($method == 2){
                            echo "Сообщение";
                        }elseif($method == 1){
                            echo "Заявка";
                        }else{
                            echo "Консультация";
                        }
                    ?>
                </div>
            <?php },

            'services' => function($array, $width, $page_name){
                $services = $array->services;
            ?>
                <div class="services" style="<?php echo $width == 'grow' ? 'flex-grow: 1;' : "width: {$width}px;"; ?>">
                    <?php
                        if(!empty($services)){
                            $services = json_decode($services);
                            echo '<div class="line">';

                            foreach($services as $service){
                                echo '<div class="tag">' . $service . '</div>';
                            }

                            echo '</div>';
                        }
                    ?>
                </div>
            <?php },

            'quantity' => function($array, $width, $page_name){ ?>
                <div class="quantity" style="<?php echo $width == 'grow' ? 'flex-grow: 1;' : "width: {$width}px;"; ?>"><?php echo $array->quantity; ?> шт.</div>
            <?php },

            'price' => function($array, $width, $page_name){ ?>
                <div class="price" style="<?php echo $width == 'grow' ? 'flex-grow: 1;' : "width: {$width}px;"; ?>"><span><?php echo $array->price . ' ' . CUR; ?></span></div>
            <?php },

            'rating' => function($array, $width, $page_name){ ?>
                <div class="rating" style="<?php echo $width == 'grow' ? 'flex-grow: 1;' : "width: {$width}px;"; ?>">
                    <ul class="star-rating">
                        <?php 
                            $ratingCount = $array->rating;
                            for( $i = 0 ; $i <= 4 ; $i++ ){ ?>
                            <li class="dashicons dashicons-star-filled<?php echo $ratingCount > 0 ? ' active' : ''; ?>"></li>
                        <?php
                            $ratingCount = $ratingCount - 1;
                        }; ?>
                    </ul>
                </div>
            <?php },

            'review' => function($array, $width, $page_name){ ?>
                <div class="review" style="<?php echo $width == 'grow' ? 'flex-grow: 1;' : "width: {$width}px;"; ?>"><?php echo $array->review; ?></div>
            <?php },

            'date' => function($array, $width, $page_name){ ?>
                <div class="date" style="<?php echo $width == 'grow' ? 'flex-grow: 1;' : "width: {$width}px;"; ?>"><?php echo $array->date; ?></div>
            <?php },

            'action' => function($array, $width, $page_name){ ?>
                <div class='action' style="<?php echo $width== 'grow' ? 'flex-grow: 1;' : "width: {$width}px;"; ?>"><input type='submit' name='<?php echo $page_name; ?>_process' class='button button-primary status-button process-btn' value='Обработан'></div>
            <?php }
        );

        $dropdown_type = array(

            'reviews' => function($array){
                if($array->review != ''){ ?>
                    <div class="message">
                        <h6>Отзыв</h6>
                        <p><?php echo $array->review ?></p>
                    </div>
                <?php }
            },

            'mail' => function($array){ ?>
                <?php if($array->message != ''){ ?>
                    <div class="message">
                        <h6>Сообщение</h6>
                        <p><?php echo $array->message ?></p>
                    </div>
                <?php }
            },

            'orders' => function($array){
                $products = explode(';', $array->products);
                $address = $array->address;
                $message = $array->message;
                $promo = $array->promo;
                $discount = $array->discount;
            ?>
                <div class="dashboard-orders">
                    <div class="orders-info">
                        <?php
                            if($address){
                                echo '
                                <div class="item">
                                    <div>Адрес</div>
                                    <p>' . $address . '</p>
                                </div>
                                ';
                            }

                            if($promo){
                                echo '
                                <div class="item">
                                    <div>Промокод</div>
                                    <p>' . $promo . '</p>
                                </div>
                                ';
                            }

                            if($discount){
                                echo '
                                <div class="item">
                                    <div>Скидка</div>
                                    <p>' . $discount . '</p>
                                </div>
                                ';
                            }

                            if($message){
                                echo '
                                <div class="item">
                                    <div>Сообщение</div>
                                    <p>' . $message . '</p>
                                </div>
                                ';
                            }
                        ?>
                    </div>

                    <div class="order-items">
                        <?php
                            if(!empty($products) && !empty($products[0])){
                                $items = [];

                                foreach($products as $item) {
                                    $item = explode(':', $item);
                                    $item_id = $item[0];
                                    $item_quantity = (int)$item[1];
                                    $item_data = product_data($item_id);
                        
                                    $item_title = $item_data->title;
                                    $item_link = '/product/' . $item_id . '/';
                                    $item_image = !empty($item_data->images->small) ? $item_data->images->small : '';
                                    if(is_array($item_data->images->small)) {
                                        $item_image = $item_data->images->small[0];
                                    } else {
                                        $item_image = $item_data->images->small;
                                    }
                        
                                    $item_price = getPrice($item_id);
                                    $item_unit_price = $item_price['price'];
                                    $item_unit_old_price = $item_price['old_price'];
                                    $discount = '';
                        
                                    $item_total_price = $item_unit_price * $item_quantity;
                                    
                                    if($item_unit_old_price) {
                                        $total_old_price = $item_unit_old_price * $item_quantity;
                                        $total_discount = $total_old_price - $item_total_price;
                        
                                        $discount = '<div class="old-price"><span class="product-old-price" data-slug="' . $item_id . '">' . formate($total_old_price) . '</span> ' . CUR . '</div>';
                                    }
                        
                                    $item_structure = '
                                    
                                    <div class="item">
                                        <div class="about">
                                            <div class="img" style="background-image: url(' . $item_image . ')"></div>
                                            <div class="name">' . $item_title . '</div>
                                        </div>
                                        <div class="price-per"><p>Цена за 1 шт.</p><div>' . formate($item_unit_price) . ' ' . CUR . '</div></div>
                                        <div class="quantity"><p>Количество</p><div>' . $item_quantity . ' шт.</div></div>
                                        <div class="price"><p>Итого</p><div>' . formate($item_total_price) . ' ' . CUR . '</div></div>
                                    </div>
                                    ';
                        
                                    $items_data[] = [
                                        'id' => $item_id,
                                        'title' => $item_title,
                                        'price' => $item_unit_price,
                                        'totalPrice' => $item_total_price,
                                        'quantity' => $item_quantity,
                                    ];
                        
                                    $items[] = $item_structure;
                                }
                            
                                $items = implode('', $items);
                                echo $items;
                            }

                        ?>
                    </div>
                </div>
            <?php
            }
        );

        foreach($results as $value){
            $id = $value->id;
            ?>
            <div class="item" data-id="<?php echo $id; ?>">
                <div class="info">
                    <div class="item-checkbox prevent-open">
                        <input id="item<?php echo $id; ?>" type="checkbox" class="checkbox-input">
                        <label for="item<?php echo $id; ?>" class="icon-check checkbox-label"></label>
                    </div>
                    <?php 
                        foreach( $items_width as $name => $width ){
                            $content_type[$name]($value, $width, $page_name);
                        }
                    ?>
                    <div class="icon-down item-arrow"></div>
                </div>

                <?php if(isset($dropdown_type[$page_name])){ ?>
                    <div class="dropdown">
                        <?php
                            echo $dropdown_type[$page_name]($value);
                        ?>
                        <div class="btns">
                            <?php if($status == 2){ ?>
                                <button name="<?php echo $page_name; ?>_recover" class="button square recover-btn">Восстановить</button>
                                <button name="<?php echo $page_name; ?>_trash_delete" class="button grey square trash-delete-btn">Удалить с корзины</button>
                            <?php }else{ ?>
                                <button name="<?php echo $page_name; ?>_delete" class="button grey square delete-btn">Удалить</button>
                            <?php }

                            if($status == 0){ ?>
                            <button name="<?php echo $page_name; ?>_process" class="button square process-btn">Обработать</button>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
                
                <div class="success-screen">
                    <span><?php echo $empty[0]; ?></span>
                </div>
                <div class="delete-screen">
                    <span><?php echo $empty[3]; ?></span>
                </div>
                <div class="recover-screen">
                    <span><?php echo $empty[4]; ?></span>
                </div>
            </div>

        <?php } 

    }else if($hide_empty == 0){
        $labels = array( 'новых', 'обработанных', 'удаленных' );
        ?>
            <h1>На данный момент нет <?php echo $labels[$status] . ' '; echo $empty[1]; ?> ...</h1>
        <?php
    }    

    die();
}
add_action( 'wp_ajax_output_items', 'output_items' );
add_action( 'wp_ajax_nopriv_output_items', 'output_items' );

// Вывести прелоудер
function preloader(){ ?>

    <div class="preloader">

        <div class="preloader-wrapper">

            <div class="preloader-content">
                <div class='spinner-wrapper'>
                    <div class='dot'></div>
                    <div class='dot'></div>
                    <div class='dot'></div>
                    <div class='dot'></div>
                    <div class='dot'></div>
                    <div class='dot'></div>
                    <div class='dot'></div>
                </div>
                <svg>
                    <defs>
                        <filter id='goo'>
                            <feGaussianBlur in='SourceGraphic' stdDeviation='8' result='blur' />
                            <feColorMatrix in='blur' mode='matrix' values='
                                1 0 0 0 0 
                                0 1 0 0 0
                                0 0 1 0 0
                                0 0 0 25 -8' result='goo' />
                            <feBlend in='SourceGraphic' in2='goo' />
                        </filter>
                    </defs>
                </svg>
            </div>

            <span><?php echo $_SERVER['HTTP_HOST']; ?></span>

        </div>

    </div>

    <?php
} 

// Поместить notification
function alert(){ ?>

    <div class="alert">
        <div class="alert-wrapper">
            <div class="content">
            <?php /*
                <div class="icon"></div>
                <div class="message"></div>
                <div class="confirm-remove">
                    <div class="time">Будет доступно через <span></span> секунд</div>
                    <button class="button remove-yes" disabled>Да</button>
                    <button class="button remove-no">Нет</button>
                </div>
            */ ?>
            </div>
            <div class="close-alert icon-close"></div>
        </div>
    </div>

    <?php 
}



function mail_template($title, $insert){
    $color = '#ef3a4b';

    $structrure = '
    <div class="content">

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <div style="background-color:#F9F9F9;font-family:Whitney, Helvetica Neue, Helvetica, Arial, Lucida Grande, sans-serif;">

        <div style="margin:0px auto;max-width:640px;">

            <table style="width:100%;">
                <tbody>

                    <tr>
                        <td style="padding:28px 0px;text-align:center;">
                            <a href="https://school.init.kz/" style=" color: ' . $color . '; font-family: \'Open Sans\', sans-serif; font-weight: 600; font-size: 24px; text-decoration: none;" target="_blank"><span style="color: #000;">school</span>.init</a>
                        </td>
                    </tr>

                    <tr style="background:#ffffff;">
                        <td style="padding:28px;">
                            <table style="width: 100%">
                                <tbody style="color:#737F8D;font-size:16px;line-height:24px;">
                                    <tr>
                                        <td colspan="2">
                                            <h2 style="font-weight: bold;font-size: 24px;color: #000;border-bottom: 1px solid rgba(0, 0, 0, 0.2);padding-bottom: 20px;">' . $title . '</h2>
                                        </td>
                                    </tr>'
                                    . $insert .
                                    '</tbody>
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td style="vertical-align:top;padding:20px 0px;">
                                    <div style="color:#99AAB5;font-size:12px;line-height:24px;text-align:center;"> Онлайн школа веб-разработки <a href="https://school.init.kz/" style="text-decoration: none; color: ' . $color . ';" target="_blank">school.init.kz</a></div>
                                </td>
                            </tr>

                        </tbody>
                    </table>

                </div>

            </div>

        </div>';

    return $structrure;
}