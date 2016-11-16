<?php
/**
 * WordPress基础配置文件。
 *
 * 这个文件被安装程序用于自动生成wp-config.php配置文件，
 * 您可以不使用网站，您需要手动复制这个文件，
 * 并重命名为“wp-config.php”，然后填入相关信息。
 *
 * 本文件包含以下配置选项：
 *
 * * MySQL设置
 * * 密钥
 * * 数据库表名前缀
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/zh-cn:%E7%BC%96%E8%BE%91_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL 设置 - 具体信息来自您正在使用的主机 ** //
/** WordPress数据库的名称 */
define('DB_NAME', 'wordpress');

/** MySQL数据库用户名 */
define('DB_USER', 'root');

/** MySQL数据库密码 */
define('DB_PASSWORD', '920210');

/** MySQL主机 */
define('DB_HOST', 'localhost');

/** 创建数据表时默认的文字编码 */
define('DB_CHARSET', 'utf8mb4');

/** 数据库整理类型。如不确定请勿更改 */
define('DB_COLLATE', '');

/**#@+
 * 身份认证密钥与盐。
 *
 * 修改为任意独一无二的字串！
 * 或者直接访问{@link https://api.wordpress.org/secret-key/1.1/salt/
 * WordPress.org密钥生成服务}
 * 任何修改都会导致所有cookies失效，所有用户将必须重新登录。
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         ',WwE-^8v;,r/gFK|W*Q}D>o$7>tux]YFgaUq5hs*2EJ+[3pQssyy9B~q>fcc8mjh');
define('SECURE_AUTH_KEY',  'Z^vh:gP=XN)C?9Y)yiM_~S)9`V8+uny@T~lu<0^N3K^#i{d7zm9j]=R&pRoQr4.n');
define('LOGGED_IN_KEY',    'Yt9_n6g`8pASc|8kLE(QQ6@e}?;lw`&Usx)1e}$E+1 BjY2=I~gf$<e6tz39i)1#');
define('NONCE_KEY',        '5.?HbOkvEUL)A0ZQ3XFanv=e4R,5u_VBv0R&C.X7BF1.&)3_uq#);0jDiDA[7-{-');
define('AUTH_SALT',        '6/eY,df[U+^ER1bg*[5[EeMyyouUqTa||a;K$C6Kw+v5W`?!Piw51qdzq%Ic0,4S');
define('SECURE_AUTH_SALT', ']|nfc5 LA37mV-+g.3fd_;;&.KAz:vhoQj.xhE^(]NImgH|KOs=k{E*$,@!60_-`');
define('LOGGED_IN_SALT',   '`mm*l4*#1`:W;h+pozcW[!{A(2m:;%Ab_16f>U19eg6[.n|cF,RQyRm+o/`b)xH!');
define('NONCE_SALT',       'snX{D/V L3UL3<FbuUNvt*Z<ah!&m8n*kw^}r{a$/Jn/P[bJi<aQkd%=]alR%>u^');
define(“FS_METHOD”, “direct”);define(“FS_CHMOD_DIR”, 0777);define(“FS_CHMOD_FILE”, 0777);

/**#@-*/

/**
 * WordPress数据表前缀。
 *
 * 如果您有在同一数据库内安装多个WordPress的需求，请为每个WordPress设置
 * 不同的数据表前缀。前缀名只能为数字、字母加下划线。
 */
$table_prefix  = 'wp_';

/**
 * 开发者专用：WordPress调试模式。
 *
 * 将这个值改为true，WordPress将显示所有用于开发的提示。
 * 强烈建议插件开发者在开发环境中启用WP_DEBUG。
 *
 * 要获取其他能用于调试的信息，请访问Codex。
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', true);

/**
 * zh_CN本地化设置：启用ICP备案号显示
 *
 * 可在设置→常规中修改。
 * 如需禁用，请移除或注释掉本行。
 */
define('WP_ZH_CN_ICP_NUM', true);

/* 好了！请不要再继续编辑。请保存本文件。使用愉快！ */

/** WordPress目录的绝对路径。 */
if ( !defined('ABSPATH') )
    define('ABSPATH', dirname(__FILE__) . '/');


/** 设置WordPress变量和包含文件。 */
require_once(ABSPATH . 'wp-settings.php');

