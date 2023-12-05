$(document).ready(function () {
  localStorage.setItem('Point', '0');
  const data = { option: [], result: 0 };
  // $('.__result').html(data.result);
  data.option.push(Math.floor(Math.random() * 4) + 1);
  while (data.result === 0) {
    const result = Math.floor(Math.random() * 9);
    if (result > data.option[0]) {
      data.result = result;
      data.option.push(data.result - data.option[0]);
    }
  }
  function pushDot(x) {
    var html = '';
    for (var i = 0; i < x; i++) {
      html += '<div class="khanh"><div class="dot"></div></div>';
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
    var random_number2 = Math.floor(Math.random() * 8) + 1;
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
  $('.item').eq(0).prev().html(pushDot(data.option[0]));
  $('.item:eq(0)').attr("data", data.option[0]);
  $('.item:eq(1)').attr("data", data.option[1]);
  $('.item').eq(1).prev().html(pushDot(data.option[1]));
  $('.item2').droppable({ drop: handleCardDrop })
  $('.item-select-after').each(function () {
    console.log('hei là:' + $(this).outerHeight());
    $(this).css("top", -$(this).outerHeight() - 5)
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

        let totalValue = data.result;
        $('.item2').prev().html(pushDot(parseInt($('.item2').attr("data"))));


        console.log(totalValue);
        var dots = $('.item-result .item-select-after .dot');
        var dot_error = parseInt($('.item2').attr("data")) - totalValue;
        if (dot_error > 0) {
          var lastFourDots = dots.slice(-dot_error);
          lastFourDots.addClass('dot_error');
        }
        if (dot_error < 0) {
          // console.log('khanh');
          $('.item2').prev().append(pushDotError(-dot_error));
        }


        setTimeout(function () {
          $('.item-select-after').each(function () {
            $(this).css("top", -$(this).outerHeight() - 5)
            console.log('chiều height là :' + $(this).outerHeight());
          })
        }, 20);
        var khanhElements = $('.item2').prev().find('.khanh'); // Lấy tất cả các phần tử có lớp .khanh
        for (var i = 0; i < data.option[0]; i++) {
          $('.item2').prev().find('.khanh').eq(i).css("opacity", 1);
        }
        var video = $("#video-tingting").get(0);
        function playVideo() {
          video.currentTime = 0; // Đặt thời gian video về 0 để chơi lại từ đầu
          video.play();
        }
        function timeout(ms) {
          return new Promise(resolve => setTimeout(resolve, ms));
        }

        async function addClassToKhanh() {
          if (khanhElements.length === data.option[0]) {
            return; // Nếu không còn phần tử .khanh nào thì dừng lại
          }

          var khanhElement = khanhElements.eq(data.option[0]); // Lấy phần tử .khanh đầu tiên
          khanhElement.addClass('animation-dot'); // Thêm lớp .animation-dot cho phần tử .khanh

          khanhElements = khanhElements.slice(1); // Loại bỏ phần tử .khanh đầu tiên khỏi danh sách
          playVideo();

          await timeout(500); // Chờ 1.2s sử dụng Promise và await
          await addClassToKhanh(); // Gọi lại hàm đệ quy
        }

        (async function () {
          await timeout(500); // Chờ 1s sử dụng Promise và await
          await addClassToKhanh(); // Gọi hàm addClassToKhanh lần đầu
          // Đoạn mã kiểm tra đúng/sai và chạy video
          console.log($('.item2').attr("data"));
          if (totalValue === parseInt($('.item2').attr("data"))) {
            localStorage.setItem('Point', '10');
            $('.__alert_false').hide();
            $('.__alert_true').show();
            $("#video-dung").get(0).play();
            // $(".__option").draggable("destroy");
          } else {
            localStorage.setItem('Point', '1');
            $('.__alert_true').hide();
            $('.__alert_false').show();
            $("#video-sai").get(0).play();
          }
        })();
      }
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
