<?php
/**
 * Основные параметры WordPress.
 *
 * Этот файл содержит следующие параметры: настройки MySQL, префикс таблиц,
 * секретные ключи и ABSPATH. Дополнительную информацию можно найти на странице
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Кодекса. Настройки MySQL можно узнать у хостинг-провайдера.
 *
 * Этот файл используется скриптом для создания wp-config.php в процессе установки.
 * Необязательно использовать веб-интерфейс, можно скопировать этот файл
 * с именем "wp-config.php" и заполнить значения вручную.
 *
 * @package WordPress
 */

define('CONCATENATE_SCRIPTS', false);

define('WP_MEMORY_LIMIT', '128M');

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'monavis_db');

/** Имя пользователя MySQL */
define('DB_USER', 'monavis_db');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', 'monoretail');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '9ByhQcHB`,U?XE7[BVueU~EJFJEiS2;h..M,u{!8]G?7S)+&%Dd+^f>jiFAP~!^g');
define('SECURE_AUTH_KEY',  'SDl.%TzoN0cdY-fVk*+;>wko]V cK`A3xziwUFZotY{io-ungIfm8/#{c0~SE=9`');
define('LOGGED_IN_KEY',    '%`|_m@OFt+;-#{+fqCSG>5T}4/|m~Q4*J8<tNm{XY6eS(#!Wk99qyrb_]}mB]pA3');
define('NONCE_KEY',        '>eoj|d5Fp]!6Cs3>+YQ8w[>=6rXtf8m0C|T|M=|,V6UFBN9@-dfyZJu]?|-xfK-e');
define('AUTH_SALT',        '$84CyBE}oEE;M+$#]YP7.mKjNuZoC/R-|/fTROdh>4|P6*w 4QB$yT.aEjlv3>8_');
define('SECURE_AUTH_SALT', 'w@V`;qwWkvQ^u#Y^%)2FT;XF/86>{&-.W1roU4;cjp&Ey`Wvb*Yg)#nM2h<TcHcM');
define('LOGGED_IN_SALT',   'w$V@_7tn-HMJXeOH.e}sR*~1{P)VD+W`]861dc+JV##<[O^m#_n4tK29Yh U_lGI');
define('NONCE_SALT',       'eo6Bo69|~!v2K9Ij*5g]!~a6V|*gFOzk2HGP-Fe,K{P)B}kby-5SR#t&|!4crLDa');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
