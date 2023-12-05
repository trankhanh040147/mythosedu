$(document).ready(function () {
  localStorage.setItem('Point', '0');
  const data = { option: [], result: 0 };
  // $('.__result').html(data.result);
  data.option.push(Math.floor(Math.random() * 5) + 2);
  while (data.result === 0) {
    data.option.push(Math.floor(Math.random() * 5) + 2);
    data.result = data.option[0] * data.option[1];
  }
  function pushDot(y, x) {
    var html = '';
    var html_child = '<div class="__box_dot_nhan">';

    for (var i = 0; i < x; i++) {
      for (var j = 0; j < y; j++) {
        html_child += '<div class="khanh"><div class="dot"></div></div>';
      }
      html_child += '</div>'
      html += html_child;
      html_child = '<div class="__box_dot_nhan">';
    }

    return html;
  }
  function pushDotError(x) {
    var html = '';
    for (var i = 0; i < x; i++) {
      html += '<div class="khanh"><div class="dot dot_add"></div></div>';
    }
    return html;
  }
  data.option.push(data.result);

  //add thêm 2 option ngẫu  nhiên
  while (data.option.length < 5) {
    var random_number2 = Math.floor(Math.random() * 40) + 1;
    if (data.option.indexOf(random_number2) === -1) {
      data.option.push(random_number2);

    }
  }
  console.log(data.option);

  $(init);
  function init() {
    var option = data.option;
    var lastThreeElements = option.slice(-3);
    // Đảo ngẫu nhiên vị trí của 3 phần tử cuối
    for (var i = lastThreeElements.length - 1; i > 0; i--) {
      var randomIndex = Math.floor(Math.random() * (i + 1));
      var temp = lastThreeElements[i];
      lastThreeElements[i] = lastThreeElements[randomIndex];
      lastThreeElements[randomIndex] = temp;
    }

    // Gán lại 3 phần tử cuối đã được đảo vị trí vào mảng option
    option.splice(-3, 3, ...lastThreeElements);
    console.log(option);
    for (let i = 2; i < option.length; i++) {
      console.log(option[i]);
      $(renderOptions(option[i]))
        .data("string", option[i])
        .attr("id", option[i])
        .appendTo(".__option-box")
        // .droppable({ drop: handleCardDrop })
        .draggable({
          containment: ".__demo",
          cursor: "move",
          revert: true,
          droptarget: ".droppable",
        })
    }
  }
  $('.item:eq(0)').text(data.option[0]);
  $('.item:eq(1)').text(data.option[1]);
  $('.item').eq(0).prev().html(pushDot(data.option[0], 1));
  console.log("log test:" + pushDot(2, 1));
  $('.item:eq(0)').attr("data", data.option[0]);
  $('.item:eq(1)').attr("data", data.option[1]);
  $('.item').eq(1).prev().html(pushDot(data.option[1], 1));
  $('.item2').droppable({ drop: handleCardDrop })
  $('.item-select-after').each(function () {
    console.log('hei là:' + $(this).outerHeight());
    $(this).css("top", -$(this).outerHeight() - 10)
    // if ($(this).outerHeight() < 13) {
    //   $(this).css("top", -19)
    // }
    // else {
    //   $(this).css("top", -$(this).outerHeight() - 5)

    // }
  })
  function handleCardDrop(even, ui) {
    if (
      $(this).text().trim() === '?'
    ) {
      $(this).attr('data', $(ui).text());
      $(this).text($(ui).text());
      ui.hide();
    }
    else {
      $(this).attr('data', $(ui).text());

      var ui_text = $(ui).text();
      $(ui).text($(this).text());
      $(this).text(ui_text);
    }
    var allItemsNotEmpty = true;
    $(".item2").each(function () {

      if ($(this).text().trim() === '') {
        allItemsNotEmpty = false;
        return false; // Dừng vòng lặp nếu có ít nhất một phần tử rỗng
      }
    });
    setTimeout(function () {
      if (allItemsNotEmpty) {
        $('.item-select-after').addClass('d-flex');
        var heigtht = 0;

        let totalValue = data.result;
        $('.item2').prev().html(pushDot(data.option[0], data.option[1]));


        // console.log(totalValue);
        // var dots = $('.item-result .item-select-after .dot');
        // var dot_error = parseInt($('.item2').attr("data")) - totalValue;
        // if (dot_error > 0) {
        //   var lastFourDots = dots.slice(-dot_error);
        //   lastFourDots.addClass('dot_error');
        // }
        // if (dot_error < 0) {
        //   // console.log('khanh');
        //   $('.item2').prev().append(pushDotError(-dot_error));
        // }


        setTimeout(function () {
          $('.item-select-after').each(function () {
            $(this).css("top", -$(this).outerHeight() - 10)
            console.log('chiều height là :' + $(this).outerHeight());
          })
        }, 50);
        // $('.item2').prev().find('.khanh').each(function () {

        //   $(this).addClass('animation-dot');

        // })
        if (totalValue === parseInt($('.item2').attr("data"))) {

          $('.__alert_false').hide();
          $('.__alert_true').show();
        } else {
          $('.__alert_true').hide();
          $('.__alert_false').show();
        }
        var video = $("#video-tingting").get(0);

        function playVideo() {
          video.currentTime = 0; // Đặt thời gian video về 0 để chơi lại từ đầu
          video.play();
        }
        var khanhElements = $('.item2').prev().find('.__box_dot_nhan'); // Lấy tất cả các phần tử có lớp .khanh
        function addToKhanh() {
          return new Promise(function (resolve) {
            if (khanhElements.length === 0) {
              resolve(); // Nếu không còn phần tử .khanh nào thì hoàn thành Promise
              return;
            }

            var khanhElement = khanhElements.eq(0);
            khanhElement.addClass('animation-dot');

            khanhElements = khanhElements.slice(1);
            // $("#video-tingting").get(0).play();
            playVideo();
            setTimeout(resolve, 500); // Gọi resolve sau 1s
          });
        }

        async function addClassToKhanh() {
          while (khanhElements.length > 0) {
            await addToKhanh();
          }
        }

        setTimeout(function () {
          addClassToKhanh().then(function () {
            // Hàm addToKhanh đã chạy xong, tiếp tục với phần code bên dưới
            console.log($('.item2').attr("data"));
            if (totalValue === parseInt($('.item2').attr("data"))) {
              localStorage.setItem('Point', '10');
              $("#video-dung").get(0).play();
            } else {
              localStorage.setItem('Point', '1');
              $("#video-sai").get(0).play();
            }
          });
        }, 800)
      };
    }, 100)

  }
  function renderOptions(option, correct) {
    let __option_correct = "";
    if (correct != null || correct != undefined) {
      __option_correct = correct ? "__option_true" : "__option_false";
    }
    return (
      ' <div class="__option ' + __option_correct + '" data="' + option + '">' + option + '</div>'

    )
  }

  $('.submit').click(function () {
    $('.point_end').text(localStorage.getItem('Point'));
    $(".modal-over").show();
    $('.modal-end-course').addClass("d-flex");
  })
  $(".__btn-return-home").click(function () {
    location.reload();
  })
})