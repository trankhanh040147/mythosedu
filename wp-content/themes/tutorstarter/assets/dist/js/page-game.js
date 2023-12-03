$(document).ready(function () {



  var ajaxurl = '/wp-admin/admin-ajax.php';
  var url = window.location.href;
  // Phân tích URL để lấy tham số courseId
  var idCourse = getUrlParameter(url, 'courseId');
  var accessToken = getUrlParameter(url, "secureToken");
  // In ra console
  //   console.log('courseId:', idCourse);
  // console.log("accessToken: " + accessToken);
  let homeUrl = '/page-game/?courseId=' + idCourse + '&secureToken=' + accessToken;
  // Hàm hỗ trợ lấy tham số từ URL
  function getUrlParameter(url, name) {
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)');
    var results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
  }
  jQuery.ajax({
    url: ajaxurl,
    type: 'GET',
    data: {
      action: 'my_course_detail',
      idCourse: idCourse,
      secureToken: accessToken,
    },
    dataType: 'json',
    success: function (data) {

      // console.log(data);
      generateRandomLevels(data.data);
    },
    error: function (xhr, status, error) {
      console.error('AJAX Error:', status, error);
      console.log(xhr.responseText); // Log the response for debugging
    }
  });

  function generateRandomLevels(data) {
    var data2 = JSON.parse(data);
    // console.log(data2);
    var x = data2.data.sessions.length;
    var numbers = [];
    for (var i = 2; i <= 17; i++) {
      numbers.push(i);
    }
    // console.log(numbers);
    function getRandomElements(arr, count) {
      var shuffled = arr.slice(0),
        i = arr.length,
        min = i - count,
        temp,
        index;
      while (i-- > min) {
        index = Math.floor((i + 1) * Math.random());
        temp = shuffled[index];
        shuffled[index] = shuffled[i];
        shuffled[i] = temp;
      }
      return shuffled.slice(min);
    }
    var randomNumbers;
    if (x < 9) {
      switch (x) {
        case 1:
          randomNumbers = [1];
          break;
        case 2:
          randomNumbers = [1, 18];
          break;
        case 3:
          randomNumbers = [1, 9, 18];
          break;
        case 4:
          randomNumbers = [1, 6, , 12, 18];
          break;
        case 5:
          randomNumbers = [1, 4, 9, 13, 18];
          break;
        case 6:
          randomNumbers = [1, 4, 8, 12, 16, 18];
          break;
        case 7:
          randomNumbers = [1, 3, 6, 9, 12, 15, 18];
          break;
        case 9:
          randomNumbers = [1, 3, 5, 7, 10, 12, 15, 18];
          break;
      }
    }
    else {
      randomNumbers = getRandomElements(numbers, x - 2);
      randomNumbers.push(1);
      randomNumbers.push(18);
    }

    randomNumbers.sort(function (a, b) {
      return a - b;
    });
    // console.log(randomNumbers);
    var html = '';
    for (var i = 1; i <= x; i++) {
      html +=
        '<div class="level-' +
        randomNumbers[i - 1] +
        ' level level_no_success" id="' +
        data2.data.sessions[i - 1].id +
        '">' +
        '<img src="/wp-content/uploads/2023/10/icon-place-success.png" alt="" class="icon-place-success">' +
        '<div class="position-relative">' +
        '<a href="/page_session?idSession=' + data2.data.sessions[i - 1].id.trim() + '&idCourse=' + idCourse + '&secureToken=' + accessToken + '"> <img src="/wp-content/uploads/2023/10/button-play.png" alt="" class="btn-play"></a>' +
        '<img src="/wp-content/uploads/2023/10/icon-active-place.png" alt="" class="icon-active-place">' +
        '</div>' +
        '<img src="/wp-content/uploads/2023/10/icon-lace-no-success.png" alt="" class="icon-place-no-success">' +
        '</div>';
    }
    $('.__box-game').append(html);
    // $('.__box-game .level:eq(0)').removeClass('level_no_success');
    // $('.__box-game .level:eq(0)').addClass('level_active');
    var idSession;
    for (var i = 0; i < data2.data.sessions.length; i++) {
      k = i + 1;
      idSession = data2.data.sessions[i].id;
      if (data2.data.sessions[i].status === "inactive") {
        $("#" + idSession).removeClass('level_active');
        $("#" + idSession).removeClass('level_success');
        $("#" + idSession).addClass('level_no_success');
      } else if (data2.data.sessions[i].status === "finished") {
        $("#" + idSession).removeClass('level_active');
        $("#" + idSession).addClass('level_success');
        $("#" + idSession).removeClass('level_no_success');
      }
      $('.__detail_modal').append('<li>Ở map ' + k + ' bạn được <span class="point_detail">' + data2.data.sessions[i].total_result_session + '</span> điểm</li>')
    }
    var idSessionInit = data2.data.sessions[0].id;
    if (data2.data.sessions[0].status === "inactive") {
      $("#" + idSessionInit).addClass('level_active');
      $("#" + idSessionInit).removeClass('level_success');
      $("#" + idSessionInit).removeClass('level_no_success');
    }
    var lastLevel = $('.__box-game .level:last-child');
    if (lastLevel.hasClass('level_success')) {
      // console.log(data2.data.total_result_course);
      $('.point_end').text(data2.data.total_result_course);
      $('.modal-end-course').show();
    }
    if (data2.data.sessions[0].status === "finished") {
      $('.__box-game .level_no_success').eq(0).addClass('level_active');
      $('.__box-game .level_no_success').eq(0).removeClass('level_no_success');
    }
    $('.__btn-return-home').click(function () {
      delete_point(data2.data.id);
      setTimeout(function () {
        window.location.href = homeUrl;
      }, 1000);
    })
  }

  // setTimeout(function () {
  //   var url = new URL(window.location.href);
  //   var params = new URLSearchParams(url.search);
  //   var idSession = params.get('idSessionComplete');
  //   console.log($("#" + idSession));
  //   $("#" + idSession).prevAll().addClass('level_success');
  //   $("#" + idSession).prevAll().removeClass('level_no_success');
  //   $("#" + idSession).prevAll().removeClass('level_active');
  //   $("#" + idSession).addClass('level_success');
  //   $("#" + idSession).removeClass('level_active');
  //   $("#" + idSession).removeClass('level_no_success');
  //   $("#" + idSession).next().addClass('level_active');
  //   $("#" + idSession).next().removeClass('level_no_success');
  //   

  //  
  // }, 2000);
  function delete_point(id) {
    var data = {
      "course_id": id,
    };
    // console.log(data);


    jQuery.ajax({
      url: ajaxurl, // Sử dụng biến ajaxurl được WordPress cung cấp
      type: 'POST',
      data: {
        action: 'my_post_delete_point_api',
        data_post: data,
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
  // function dumpCookies() {
  //   var cookies = document.cookie.split(';');
  //   for (var i = 0; i < cookies.length; i++) {
  //     var cookie = cookies[i].trim();
  //     console.log(cookie);
  //   }
  // }
  // console.log("Tất cả các cookie:    ")
  // // Gọi hàm để hiển thị tất cả các cookie
  // dumpCookies();

  jQuery.ajax({
    url: ajaxurl, // Đường dẫn đến file admin-ajax.php
    type: 'POST',
    data: {
      action: 'get_cookies' // Tên action đã đăng ký
    },
    success: function (response) {
      if (response.success) {
        var cookiesData = response.data;
        // Xử lý dữ liệu cookie ở đây
        for (var key in cookiesData) {
          if (cookiesData.hasOwnProperty(key)) {
            // console.log(key + " => " + cookiesData[key]);
          }
        }
      } else {
        // Xử lý lỗi
        // console.log(response.data);
      }
    },
    error: function (error) {
      // Xử lý lỗi
      console.log(error);
    }
  });

})
// get all cookie
