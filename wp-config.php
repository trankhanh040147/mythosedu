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
define( 'DB_NAME', 'mythosedu_lms' );


/** Username của database */
define( 'DB_USER', 'root' );

/** Mật khẩu của database */
define( 'DB_PASSWORD', '040147' );

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
define( 'AUTH_KEY',         'ghU.y9;Kh0>1|J}AU8DmH #NXCP{`!N2,}}<`?VO2aIFi1<k?apLeM:yChR~ETei' );
define( 'SECURE_AUTH_KEY',  '*%A{B~2CR%V5G_eBjRo_aR(jnuo%;Jh_$F{{/=%X}srVz4Da&b0&jrW3T.8G)*)?' );
define( 'LOGGED_IN_KEY',    '2X-(6k9X]+~CL}mGCN8UzzJrGm=~b|#|^Qz4|UQD 4h9!|=So9nP)T_cxsg=t5*l' );
define( 'NONCE_KEY',        '-D>#3gGI&*SV7rrUMBd[UG-mFVe=G_2uG5%$/2eOesX&(%U4~/^ojNZ0Vtet|P&W' );
define( 'AUTH_SALT',        'xqA,;dafSU]!j#^uL_K@z78dH7ItfYW^:UocJUA62MVwf8[$zykT(Vy1xxYkJtm}' );
define( 'SECURE_AUTH_SALT', 'c]7DisxGuYG`Nh-Vsm[_Z2GKe#/I5ersM&w*gK?<f6b7$I|M|EINyP|_,:L`Ln:F' );
define( 'LOGGED_IN_SALT',   ':g6U$&2<X1=to, V=O5%S|PKa-jP!vPq[MfyUvp;YJQ[_`KmOPd55aV!g IKo2v]' );
define( 'NONCE_SALT',       'Sun*q4U-!k@F.&&d!!/;t~$g^s_nnphD93fr}>zx|Y3nz-A8a;$vk)w~=(Z>HOk[' );

/**#@-*/

/**
 * Tiền tố cho bảng database.
 *
 * Đặt tiền tố cho bảng giúp bạn có thể cài nhiều site WordPress vào cùng một database.
 * Chỉ sử dụng số, ký tự và dấu gạch dưới!
 */
$table_prefix  = 'wp_';

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
