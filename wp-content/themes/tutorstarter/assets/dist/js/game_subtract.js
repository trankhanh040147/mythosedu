$(document).ready(function () {
  localStorage.setItem('Point', '0');
  const data = { option: [], result: 0 };
  // $('.__result').html(data.result);
  data.option.push(Math.floor(Math.random() * 5) + 4);
  while (data.result === 0) {
    const result = Math.floor(Math.random() * 5) + 1;
    if (result < data.option[0]) {
      data.result = result;
      data.option.push(data.option[0] - data.result);
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
        $('.item2').prev().html(pushDot(parseInt($('.item').eq(0).attr("data"))));



        setTimeout(function () {
          $('.item-select-after').each(function () {
            $(this).css("top", -$(this).outerHeight() - 5)
          })
        }, 50);
        var item2 = $('.item2').prev().find('.khanh');

        function delay(ms) {
          return new Promise(resolve => setTimeout(resolve, ms));
        }
        var video = $("#video-tingting").get(0);
        function playVideo() {
          video.currentTime = 0; // Đặt thời gian video về 0 để chơi lại từ đầu
          video.play();
        }
        async function processItems() {
          function additem() {
            if (item2.length === 0) {
              return;
            }

            var items = item2.eq(0);
            items.addClass('animation-dot');

            item2 = item2.slice(1);

            return delay(0).then(additem);
          }

          await delay(0);
          await additem();

          var dots = $('.item-result .item-select-after .dot');
          var dot_error = data.option[1];
          var lastFourDots = dots.slice(-dot_error);

          function additemError() {
            if (lastFourDots.length === 0) {
              return Promise.resolve(); // Return a resolved Promise when finished
            }

            var itemErrror = lastFourDots.eq(-1);
            itemErrror.addClass('dot_error');
            lastFourDots = lastFourDots.slice(0, -1);
            playVideo();


            return delay(500).then(additemError); // Use delay() to return a Promise with delay

            // You can remove the setTimeout function and play the video directly here
          }

          await additemError(); // Wait for additemError to finish

          if (totalValue === parseInt($('.item2').attr("data"))) {
            $("#video-dung").get(0).play();
            localStorage.setItem('Point', '10');
            $('.__alert_false').hide();
            $('.__alert_true').show();
            // $(".__option").draggable("destroy");
          } else {
            $("#video-sai").get(0).play();
            localStorage.setItem('Point', '1');
            $('.__alert_true').hide();
            $('.__alert_false').show();
          }
        }

        processItems();

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