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
// define('DB_NAME', 'u199319889_mythosedu_uat');
define( 'DB_NAME', 'u199319889_mythosedu_v1' );


/** Username của database */
//  define('DB_USER', 'root');
 define( 'DB_USER', 'u199319889_root_v1' );


/** Mật khẩu của database */
 define('DB_PASSWORD', '040147');
 define( 'DB_PASSWORD', 'Mythosedu47' );

/** Hostname của database */
define('DB_HOST', 'localhost');


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
define('AUTH_KEY',         'ghU.y9;Kh0>1|J}AU8DmH #NXCP{`!N2,}}<`?VO2aIFi1<k?apLeM:yChR~ETei');
define('SECURE_AUTH_KEY',  '*%A{B~2CR%V5G_eBjRo_aR(jnuo%;Jh_$F{{/=%X}srVz4Da&b0&jrW3T.8G)*)?');
define('LOGGED_IN_KEY',    '2X-(6k9X]+~CL}mGCN8UzzJrGm=~b|#|^Qz4|UQD 4h9!|=So9nP)T_cxsg=t5*l');
define('NONCE_KEY',        '-D>#3gGI&*SV7rrUMBd[UG-mFVe=G_2uG5%$/2eOesX&(%U4~/^ojNZ0Vtet|P&W');
define('AUTH_SALT',        'xqA,;dafSU]!j#^uL_K@z78dH7ItfYW^:UocJUA62MVwf8[$zykT(Vy1xxYkJtm}');
define('SECURE_AUTH_SALT', 'c]7DisxGuYG`Nh-Vsm[_Z2GKe#/I5ersM&w*gK?<f6b7$I|M|EINyP|_,:L`Ln:F');
define('LOGGED_IN_SALT',   ':g6U$&2<X1=to, V=O5%S|PKa-jP!vPq[MfyUvp;YJQ[_`KmOPd55aV!g IKo2v]');
define('NONCE_SALT',       'Sun*q4U-!k@F.&&d!!/;t~$g^s_nnphD93fr}>zx|Y3nz-A8a;$vk)w~=(Z>HOk[');
define( 'DDL_DOMAIN',      '518ddbefbbe009410fa92cc4c3d7c8d9' );
define( 'DDL_INTERNAL',    true );

/**#@-*/

/**
 * Tiền tố cho bảng database.
 *
 * Đặt tiền tố cho bảng giúp bạn có thể cài nhiều site WordPress vào cùng một database.
 * Chỉ sử dụng số, ký tự và dấu gạch dưới!
 */
$table_prefix  = 'wp_';
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

/******************* TRAININGHUB SETTTINGS ***************************/
define('__SENDEMAIL_ON_OFF', '__MAIL_ON'); // __MAIL_ON: enable; __MAIL_OFF: disible
define('_DELETE_DRAFT_', 5); // number of minutes to delete draft courses

define('__USING_ASA_SYSTEM', 'YES'); // number of minutes to delete draft courses

define('_DEFINE_GROUPS_USER', array(
        "ASA"=>"ASA",
        "HR"=>"HR",
        "TQM"=>"TQM",
));
  
define('_BRANCHS_', array(
        "HNI_CTM"=>"Cơ sở Hà Nội - CTM",
 "HCM_VPTT"=>"Văn Phòng Trung Tâm VUS Hồ Chí Minh",
 "HCM_NTMK"=>"Cơ sở Hồ Chí Minh - Nguyễn Thị Minh Khai",
 "HCM_ADV"=>"Cơ sở Hồ Chí Minh - An Dương Vương",
 "HCM_BH"=>"Cơ sở Hồ Chí Minh - Bà Hom",
 "HCM_BL"=>"Cơ sở Hồ Chí Minh - Bình Long",
 "HCM_BM"=>"Cơ sở Hồ Chí Minh - Bình Minh",
 "HCM_CH"=>"Cơ sở Hồ Chí Minh - Cộng Hòa",
 "HCM_DXH"=>"Cơ sở Hồ Chí Minh - Đỗ Xuân Hợp",
 "HCM_GR"=>"Cơ sở Hồ Chí Minh - Green River",
 "HCM_HB"=>"Cơ sở Hồ Chí Minh - Hòa Bình",
 "HCM_HG"=>"Cơ sở Hồ Chí Minh - Hậu Giang",
 "HCM_KH"=>"Cơ sở Hồ Chí Minh - Khánh Hội",
 "HCM_LTT"=>"Cơ sở Hồ Chí Minh - Lê Trọng Tấn",
 "HCM_MS"=>"Cơ sở Hồ Chí Minh - Morning Star",
 "HCM_NAT"=>"Cơ sở Hồ Chí Minh - Nguyễn Ảnh Thủ",
 "HCM_NAT2"=>"Cơ sở Hồ Chí Minh - Nguyễn Ảnh Thủ 2",
 "HCM_NCT"=>"Cơ sở Hồ Chí Minh - Nguyễn Chí Thanh",
 "HCM_NDT"=>"Cơ sở Hồ Chí Minh - Nguyễn Duy Trinh",
 "HCM_NK"=>"Cơ sở Hồ Chí Minh - Nguyễn Kiệm",
 "HCM_NKV"=>"Cơ sở Hồ Chí Minh - Nguyễn Khắc Viện",
 "HCM_NTT"=>"Cơ sở Hồ Chí Minh - Nguyễn Thị Thập",
 "HCM_NVTA"=>"Cơ sở Hồ Chí Minh - Nguyễn Văn Tăng",
 "HCM_PXL"=>"Cơ sở Hồ Chí Minh - Phan Xích Long",
 "HCM_QT"=>"Cơ sở Hồ Chí Minh - Quang Trung",
 "HCM_TC"=>"Cơ sở Hồ Chí Minh - Trường Chinh",
 "HCM_TL"=>"Cơ sở Hồ Chí Minh - Tên Lửa",
 "HCM_TNV"=>"Cơ sở Hồ Chí Minh - Tô Ngọc Vân",
 "HCM_UT"=>"Cơ sở Hồ Chí Minh - Út Tịch",
 "HCM_VTS"=>"Cơ sở Hồ Chí Minh - Võ Thị Sáu",
 "HCM_TK"=>"Cơ sở Hồ Chí Minh - Kids Tô Ký",
 "HCM_TN"=>"Cơ sở Hồ Chí Minh - Kids Trần Não",
 "HCM_TVD"=>"Cơ sở Hồ Chí Minh - Kids Tô Vĩnh Diện",
 "HCM_TK2"=>"Cơ sở Hồ Chí Minh - Tô Ký 2",
 "HNI_VPTT"=>"Văn Phòng Trung Tâm VUS Hà Nội",
 "HNI_NLB"=>"Cơ sở Hà Nội - Nguyễn Lương Bằng",
 "HNI_GP"=>"Cơ sở Hà Nội - Golden Palace",
 "HNI_TCT"=>"Cơ sở Hà Nội - Times City",
 "HNI_VG"=>"Cơ sở Hà Nội - Vinhomes Gardenia",
 "DNA_NVL"=>"Cơ sở Đà Nẵng - Nguyễn Văn Linh",
 "DNI_PT"=>"Cơ sở Đồng Nai - Phan Trung",
 "DNI_VTS"=>"Cơ sở Đồng Nai - Võ Thị Sáu",
 "BDG_BCM"=>"Cơ sở Bình Dương - Becamex",
 "BDG_CMT8"=>"Cơ sở Bình Dương - Cách Mạng Tháng Tám",
 "BDG_DA"=>"Cơ sở Bình Dương - Dĩ An",
 "BRV_TCD"=>"Cơ sở Vũng Tàu - Trương Công Định",
 "HCM_OL"=>"Cơ sở Hồ Chí Minh - Online",
 "CTO_NK"=>"Cơ sở Cần Thơ - Nguyễn Kim",
 "TNH_304"=>"Cơ sở Tây Ninh - 30/4",
 "VLG_PTB"=>"Cơ sở Vĩnh Long - Phạm Thái Bường",
 "BMT_PBC"=>"Cơ sở Buôn Mê Thuột – Phan Bội Châu",
 "HCM_NVTH"=>"Cơ sở Hồ Chí Minh - Nguyễn Văn Thủ",
 "HCM_KDV"=>"Cơ sở Hồ Chí Minh - Kinh Dương Vương",
 "HCM_COR"=>"Cơ sở Hồ Chí Minh - Nhóm KH Doanh Nghiệp",
 "HNI_COR"=>"Cơ sở Hà Nội - Nhóm KH Doanh Nghiệp",
 "HCM_OST"=>"Cơ sở Online Stem",
 "HCM_SSU"=>"Summer",
 "HCM_NK2"=>"Cơ sỏ Hồ Chí Minh - Nguyễn Kiệm 2",
 "HNI_CT"=>"Cơ sở Hà Nội - Century Tower",
 "HCM_VVV"=>"Cơ sở Hồ Chí Minh - Võ Vân Vân",
 "DNI_LD"=>"Cơ sở Đồng Nai - Lê Duẩn",
 "DNI_HV"=>"Cơ sở Đồng Nai - Hùng Vương",
 "LAN_MTT"=>"Cơ sở Long An - Mai Thị Tốt",
 "HCM_TL8"=>"HCM_TL8 Cơ sở Hồ Chí Minh - Củ Chi Tỉnh Lộ 8",
 "BDG_DA2"=>"Cơ sở Bình Dương - Dĩ An 2",
 "TGG_NKKN"=>"Cơ sở Tiền Giang - Nam Kỳ Khởi Nghĩa",
 "HCM_HTP"=>"Cơ sở Hồ Chí Minh - Huỳnh Tấn Phát",
 "HCM_LQD"=>"Cơ sở Hồ Chí Minh - Lê Quang Định",
 "HCM_NO"=>"Cơ sở Hồ Chí Minh - Nguyễn Oanh",
 "HCM_LDC"=>"Cơ sở Hồ Chí Minh - Lương Định Của",
 "EDU_BMT"=>"Công ty giáo dục quốc tế VUS",
 "BRV_NTT"=>"Cơ sở Bà Rịa - Nguyễn Tất Thành",
 "BDG_HV"=>"Cơ sở Bình Dương - Hùng Vương",
 "BDG_NVT"=>"Cơ sở Bình Dương - Nguyễn Văn Tiết",
 "HCM_PVD"=>"Cơ sở Hồ Chí Minh - Phạm Văn Đồng",
 "HCM_LTK"=>"Cơ sở Hồ Chí Minh - Lý Thường Kiệt",
 "HCM_PVH"=>"Cơ sở Hồ Chí Minh - Phan Văn Hớn",
 "HCM_VVN"=>"Cơ sở Hồ Chí Minh - Võ Văn Ngân",
 "GLI_PDP"=>"Cơ sở Gia Lai - Phan Đình Phùng",
 "KHA_LTP"=>"Cơ sở Khánh Hòa - Lê Thành Phương",
 "BDH_LL"=>"Cơ sở Bình Định - Lê Lợi",
 "HNI_AH"=>"Cơ sở Hà Nội - An Hưng",
 "HCM_HD"=>"Cơ sở Hồ Chí Minh - Hoàng Diệu",
 "KGG_BTH"=>"Cơ sở Kiên Giang - Ba Tháng Hai",
 "DEV_HCM"=>"CÔNG TY TNNH VUS DEVELOPMENT",
 "MGM_HCM"=>"CÔNG TY TNHH VUS MANAGEMENT",
 "KTM_TP"=>"Cơ sở Kon Tum - Trần Phú",
 "EDU_SSU"=>"Summer BMT",
 "LDG_PDP"=>"Cơ sở Lâm Đồng - Phan Đình Phùng",
 "HNI_AB"=>"Cơ sở Hà Nội - An Bình",
 "PYN_01"=>"Cơ sở Phú Yên - 01",
 "HNI_VP"=>"Cơ sở Hà Nội - Văn Phú",
 "HCM_NHT"=>"Cơ sở Hồ Chí Minh - Nguyễn Hữu Trí",
 "HNI_LD"=>"Cơ sở Hà Nội - Linh Đàm",
 "HCM_LVL"=>"Cơ sở Hồ Chí Minh - Lê Văn Lương"
 ));
  

/******************* ./END TRAININGHUB SETTTINGS ***************************/

/* Đó là tất cả thiết lập, ngưng sửa từ phần này trở xuống. Chúc bạn viết blog vui vẻ. */

define('FS_METHOD', 'direct');

/** Đường dẫn tuyệt đối đến thư mục cài đặt WordPress. */
if (!defined('ABSPATH'))
        define('ABSPATH', dirname(__FILE__) . '/');

/** Thiết lập biến và include file. */
require_once(ABSPATH . 'wp-settings.php');
