<?php
/**
 * Cấu hình cơ bản cho WordPress
 *
 * Trong quá trình cài đặt, file "wp-config.php" sẽ được tạo dựa trên nội dung
 * mẫu của file này. Bạn không bắt buộc phải sử dụng giao diện web để cài đặt,
 * chỉ cần lưu file này lại với tên "wp-config.php" và điền các thông tin cần thiết.
 *
 * File này chứa các thiết lập sau:
 *
 * * Thiết lập MySQL
 * * Các khóa bí mật
 * * Tiền tố cho các bảng database
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Thiết lập MySQL - Bạn có thể lấy các thông tin này từ host/server ** //
/** Tên database MySQL */

define( 'DB_NAME', '' );

/** Username của database */
define( 'DB_USER', '' );

/** Mật khẩu của database */
define( 'DB_PASSWORD', '' );

/** Hostname của database */
define( 'DB_HOST', 'localhost' );

/** Database charset sử dụng để tạo bảng database. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Kiểu database collate. Đừng thay đổi nếu không hiểu rõ. */
define('DB_COLLATE', '');

/**#@+
 * Khóa xác thực và salt.
 *
 * Thay đổi các giá trị dưới đây thành các khóa không trùng nhau!
 * Bạn có thể tạo ra các khóa này bằng công cụ
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Bạn có thể thay đổi chúng bất cứ lúc nào để vô hiệu hóa tất cả
 * các cookie hiện có. Điều này sẽ buộc tất cả người dùng phải đăng nhập lại.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'Is/6Kc^v)7fRy.[7Wg`CjgA4LUu1=T[:.,-fV-j9a;S]Xsvd1v67D@ U=kN{JUK*' );
define( 'SECURE_AUTH_KEY',  'CROXT0k!?%D6DtXb0!vU.bqA>d MMkm%u+hh5&(Q2i>`mVhv>g<Kg.J}nTw5_nAc' );
define( 'LOGGED_IN_KEY',    'F*T= 0Vtr h#1./a2pl^(AOyi748 ~9&fMgHk&H?xB}Dc~na~:$s)ATUEAx [g?J' );
define( 'NONCE_KEY',        'yfJnQ7OmjYdzVc@g3uu1[BoY(1#W Ey.h[h.dRfazt;kVd$PrSw.soMXBH.%o4$Z' );
define( 'AUTH_SALT',        '@zPm+MT^^9S>EakTYeC]jjyHeKIDJ_%+u#&k@#*0K.7Adl`GC*eEy-r7BBrJPd-q' );
define( 'SECURE_AUTH_SALT', 'xVocUZ?V.m3j%u&grK@X.^nSwCh6Cmf%x47V8C{(n)0(C2;kDx%hqF=*AE0A,,8Y' );
define( 'LOGGED_IN_SALT',   'SAMRPRe0mK8ymv64dnBkVBE~/h>b} ]9=e^*5=0@6e`)/(3BKN;.~rtO]BWU3m+^' );
define( 'NONCE_SALT',       'Q2AuZh[r9k&j]if[?|&X6aI~UnJ+;O,2Ham&-d5J7^Q%{w.U#ti(?/@Sjs^PA*kd' );

/**#@-*/

/**
 * Tiền tố cho bảng database.
 *
 * Đặt tiền tố cho bảng giúp bạn có thể cài nhiều site WordPress vào cùng một database.
 * Chỉ sử dụng số, ký tự và dấu gạch dưới!
 */
$table_prefix  = 'b_';
/*define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', true);
define('DOMAIN_CURRENT_SITE', 'eazyweb.me');
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);
define( 'SCRIPT_DEBUG', true );
*/

define( 'DDL_DOMAIN', '9ebee433868f2b7b99f74aa6ea14c578' );
define( 'DDL_INTERNAL', true );

// Setting default theme for new sites
define( 'WP_DEFAULT_THEME', 'Drag & drop layout' );
/**
 * Dành cho developer: Chế độ debug.
 *
 * Thay đổi hằng số này thành true sẽ làm hiện lên các thông báo trong quá trình phát triển.
 * Chúng tôi khuyến cáo các developer sử dụng WP_DEBUG trong quá trình phát triển plugin và theme.
 *
 * Để có thông tin về các hằng số khác có thể sử dụng khi debug, hãy xem tại Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* Đó là tất cả thiết lập, ngưng sửa từ phần này trở xuống. Chúc bạn viết blog vui vẻ. */

/** Đường dẫn tuyệt đối đến thư mục cài đặt WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Thiết lập biến và include file. */
require_once(ABSPATH . 'wp-settings.php');
