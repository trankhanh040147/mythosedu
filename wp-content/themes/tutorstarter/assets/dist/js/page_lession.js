$(document).ready(function () {
  var ajaxurl = '/wp-admin/admin-ajax.php';
  var arraylesstion;

  var url = new URL(window.location.href);
  // var params = new URLSearchParams(url.search);
  // var idSession = params.get('idSession');
  // console.log(idSession);
  // var idCourse = params.get('idCourse');
  var idCourse = getUrlParameter(url, 'idCourse');
  var idSession = getUrlParameter(url, 'idSession');
  var accessToken = getUrlParameter(url, "secureToken");
  function getUrlParameter(url, name) {

    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)');
    var results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
  }
  var homeUrl = 'https://mythosedu.com/';
  var togglePoint = 0;
  // Thực hiện cuộc gọi AJAX GET đến AJAX endpoint đã đăng ký
  jQuery.ajax({
    url: ajaxurl, // Biến global được định nghĩa trong WordPress
    type: 'GET', // Đặt loại cuộc gọi thành GET
    data: {
      action: 'my_course_detail',
      idCourse: idCourse,
      secureToken: accessToken,
    },
    dataType: 'json',
    success: function (data) {
      var data2 = JSON.parse(data.data)
      // console.log(data2.data.sessions);
      var x = data2.data.sessions.length;
      for (var i = 0; i < x; i++) {
        if (data2.data.sessions[i].id === idSession) {
          arraylesstion = data2.data.sessions[i];
          templateName = data2.data.sessions[i].session_game_type;
          togglePoint_data = data2.data.sessions[i];
          // console.log("khanhsfasfasdfasdf"+ templateName);
          break;
        }
      }
      renderIframe(arraylesstion, templateName);
    }
  });

  var templateName = 'game_plus'; // Tên mẫu

  // post Point
  function post_point(id, point) {
    var data = {
      course_id: idCourse,
      sesion_id: idSession,
      lesson_id: id,
      score: point,
      max_score: 10,
      opened: 1697530603486,
      finished: 1698110948086,
      time: 0
    };
    // var data_post = JSON.stringify(data);
    var data_post = (data);

    // console.log(data_post);
    jQuery.ajax({
      url: ajaxurl, // Sử dụng biến ajaxurl được WordPress cung cấp
      type: 'POST',
      data: {
        action: 'my_post_point_api',
        data_post: data_post,
      },
      dataType: 'json',
      success: function (response) {
        // console.log(response);
      },
      error: function (jqXHR, textStatus, errorThrown) {
        // console.log("jqXHR", jqXHR);
        // console.log("textStatus", textStatus);
        // console.log("errorThrown", errorThrown);
      }
    });
  }
  let homeGameUrl = 'https://mythosedu.com/page-game/?courseId=' + idCourse + '&secureToken=' + accessToken;
  // data user
  function renderIframe(data, templateName) {
    // $('.__btn-endgame').attr("href", "/page-game?idSessionComplete=" + sessionId);
    $('.__btn-endgame').attr("href", homeGameUrl);
    var length = data.lessons.length;
    templateName = templateName;
    var iframeContainer = $('.__lession-box'); // Lựa chọn phần tử .__lession-box
    // tạo array lưu điểm tạm thời
    var arr_point = [];
    for (var i = 0; i < length; i++) {
      arr_point.push(0);
    }
    console.log(arr_point);
    // Hàm lấy template game
    function getTemplateGame(templateName) {
      return new Promise(function (resolve, reject) {
        jQuery(document).ready(function ($) {
          $.ajax({
            url: ajaxurl,
            type: 'POST',
            dataType: 'html',
            data: {
              action: 'get_template_game',
              template: templateName
            },
            success: function (response) {
              resolve(response); // Trả về giá trị thành công
            },
            error: function (error) {
              reject(error); // Trả về lỗi
            }
          });
        });
      });
    }

    // Tạo iframe với sandbox và thêm vào .__lession-box
    function createIframe(template) {
      var parent = $('<div class="col-12  flex-column justify-content-center align-items-center __box-iframe"></div>');
      var iframe = $('<iframe></iframe>');
      iframe.prop('srcdoc', template); // Đặt nội dung template cho iframe
      // Tùy chỉnh kích thước iframe
      // Đặt thuộc tính sandbox để đảm bảo script không ảnh hưởng lẫn nhau
      iframe.prop('sandbox', 'allow-scripts allow-same-origin');
      parent.append(iframe);
      // Thêm iframe vào .__lession-box
      iframeContainer.append(parent);
      $('.__lession-box .__box-iframe:nth-child(1)').addClass(' __box-iframe-active');
    }
    // Lấy template và tạo các iframe
    getTemplateGame(templateName)
      .then(function (template) {
        // Tạo ba iframe độc lập sử dụng cùng một template và thêm vào .__lession-box
        for (var i = 0; i < length; i++) {
          createIframe(template);
        }
      })
      .catch(function (error) {
        // console.log(error);
      });

    var length = arraylesstion.lessons.length;
    var indexActive = 0;
    if (indexActive == 0) {
      $('.__btn-prev').hide();
    }

    console.log(arr_point);
    var k = true;
    window.addEventListener('storage', function (event) {
      if (event.key === 'Point') {
        // Giá trị của 'myKey' trong LocalStorage đã thay đổi
        var newValue = event.newValue;
        togglePoint = togglePoint + parseInt(newValue) - arr_point[indexActive];

        $('.___score_point').text(togglePoint);
        arr_point[indexActive] = parseInt(newValue);
        console.log(arr_point);

        // Xử lý logic tại đây
      }
    });
    var key_text;
    $('.__btn-next').click(function () {


      var __point = parseInt(localStorage.getItem('Point'));
      if (__point == 0) {
        __point = 1;
      }
      if (arr_point[indexActive] == 0) {
        arr_point[indexActive] = 1;
        togglePoint += 1;
        $('.___score_point').text(togglePoint);
      }
      post_point(data.lessons[indexActive].id, __point);


      if (indexActive == length - 1) {
        $('.modal-end').html('<div class="__toggle_point">Tổng điểm của bạn là: ' + togglePoint + '</div>');
        $('.modal-end').addClass('d-flex');

      }
      else {


        // console.log(indexActive);
        $('.__lession-box .__box-iframe').eq(indexActive).removeClass('__box-iframe-active');
        indexActive++;
        key_text = indexActive + 1;
        $('.__text-key').text(key_text);
        // console.log(arr_point[indexActive]);

        if (arr_point[indexActive] !== 0) {
          localStorage.setItem('Point', arr_point[indexActive]);
        }
        else {
          localStorage.setItem('Point', '1');

        }
        $('.__lession-box .__box-iframe').eq(indexActive).addClass('__box-iframe-active');

        $('.__btn-prev').show();

      }

    });
    $('.__btn-prev').click(function () {
      if (indexActive == 0) {
        $('.__btn-prev').hide();
        $('.__text-key').text(1);

      }
      else {
        // console.log(indexActive);
        $('.__lession-box .__box-iframe').eq(indexActive).removeClass('__box-iframe-active');
        indexActive--;
        key_text = indexActive + 1;
        $('.__text-key').text(key_text);

        localStorage.setItem('Point', arr_point[indexActive]);


        $('.__lession-box .__box-iframe').eq(indexActive).addClass('__box-iframe-active');
        if (indexActive == 0) {
          $('.__btn-prev').hide();
        }

      }

    });
  }

})