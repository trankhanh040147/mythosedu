$(document).ready(function () {
  localStorage.setItem('Point', '0');
  // const word = ["1", "2", "3", "4", "5", "6","15"];
  var word = [];
  var __answer_word = [];
  var characters = [];
  while (word.length < 6) {
    var randomNumber = Math.floor(Math.random() * 9 + 1);
    if (word.indexOf(randomNumber) === -1) {
      word.push(randomNumber);
    }
  }
  word.sort(function (a, b) {
    return b - a;
  });
  word = word.map(function (item) {
    return String(item);
  });
  console.log(word);
  __answer_word = [...word];
  characters = [...word];
  console.log(characters);
  console.log(__answer_word);

  let points = 0;
  $(init);

  function init() {
    // Reset the game
    points = 0;

    //shuffled characters
    let shuffled = [];
    do {
      shuffled = shuffle(characters);
    } while (checkPositionIsTrue(shuffled, __answer_word));

    //RENDER character
    $('.___reorder_text_frame').html('');
    for (let i = 0; i < shuffled.length; i++) {
      $(renderCharacter(__answer_word[i], shuffled[i]))
        .data("string", __answer_word[i])
        .attr("id", __answer_word[i])
        .appendTo(".___reorder_text_frame")
        .droppable({ drop: handleCardDrop })
        .draggable({
          containment: ".___reorder_main",
          cursor: "move",
          revert: true,
          droptarget: ".droppable",
        });
    }
  }
  setTimeout(function () {
    $('.___reorder_text_frame .___character_frame:nth-child(6)>span').css("margin-right", 0);
  }, 500);
  //DRAG & DROP 🔥🔥🔥
  function handleCardDrop(event, ui) {
    const thisDragString = ui.children()[0].attributes["data-text"].value;
    const thisResultString = ui.draggable().data("string");
    const targetString = $(this).children()[0].attributes["data-text"].value;
    const targetResultString = $(this).droppable().data("string");


    if (
      thisDragString != targetResultString &&

      targetString != thisResultString
    ) {
      $("#video-sai").get(0).play();
      $(ui).replaceWith(
        $(renderCharacter(thisResultString, targetString, false))
          .data("string", thisResultString)
          .attr("data", thisResultString)
          .droppable({ drop: handleCardDrop })
          .draggable({
            containment: ".___reorder_main",
            cursor: "move",
            revert: true,
            droptarget: ".droppable",
          })
      );
      $($(ui).children()[0]).addClass("___cha_false");
      $(this).replaceWith(
        $(renderCharacter(targetResultString, thisDragString, false))
          .data("string", targetResultString)
          .attr("data", targetResultString)
          .droppable({ drop: handleCardDrop })
          .draggable({
            containment: ".___reorder_main",
            cursor: "move",
            revert: true,
            droptarget: ".droppable",
          })
      );
      $($(this).children()[0]).addClass("___cha_false");
      return;
    }

    if (
      thisDragString != targetResultString &&

      targetString == thisResultString
    ) {
      $("#video-bg").get(0).play();
      $(ui).replaceWith(renderCharacter(thisResultString, targetString, true));
      $($(ui).children()[0]).addClass("___cha_false");
      $(this).replaceWith(
        $(renderCharacter(targetResultString, thisDragString, false))
          .data("string", targetResultString)
          .attr("data", targetResultString)
          .droppable({ drop: handleCardDrop })
          .draggable({
            containment: ".___container",
            cursor: "move",
            revert: true,
            droptarget: ".droppable",
          })
      );
      $($(this).children()[0]).addClass("___cha_true");

      points++;
      victory(points);
      return;
    }

    if (
      thisDragString == targetResultString &&

      targetString != thisResultString
    ) {
      $("#video-bg").get(0).play();

      $(ui).replaceWith(
        $(renderCharacter(thisResultString, targetString, false))
          .data("string", thisResultString)
          .attr("data", thisResultString)
          .droppable({ drop: handleCardDrop })
          .draggable({
            containment: ".___container",
            cursor: "move",
            revert: true,
            droptarget: ".droppable",
          })
      );
      $(this).replaceWith(
        renderCharacter(targetResultString, targetResultString, true)
      );
      $($(this).children()[0]).addClass("___cha_false");
      $(ui).removeClass("droppable draggable dragaware");
      $($(ui).children()[0]).addClass("___cha_true");
      $(ui).draggable("disable");
      $(ui).droppable("disable");

      points++;
      victory(points);
      return;
    }

    if (
      thisDragString == targetResultString &&

      targetString == thisResultString
    ) {
      $("#video-bg").get(0).play();

      $(this).replaceWith(
        renderCharacter(targetResultString, targetResultString, true)
      );
      $(this).removeClass("droppable draggable dragaware");
      $($(this).children()[0]).addClass("___cha_true");
      $(this).draggable("disable");
      $(this).droppable("disable");

      $(ui).replaceWith(
        renderCharacter(thisResultString, thisResultString, true)
      );
      $(ui).removeClass("droppable draggable dragaware");
      $($(ui).children()[0]).addClass("___cha_true");
      $(ui).draggable("disable");
      $(ui).droppable("disable");

      points = points + 2;
      victory(points);
      return;
    }
  }

  //RANDOM CHARACTERS
  function shuffle(array) {
    return array.sort(function () {
      return Math.random() - 0.5;
    });
  }
  //CHECK Position Character position is euqal origin position
  function checkPositionIsTrue(shuffled, answer) {
    for (let i = 0; i < shuffled.length; i++)
      if (shuffled[i] == answer[i]) return true;
    return false;
  }
  //VICTORY 🎉🎉🎉
  function victory(point) {
    if (point == word.length) {
      $("#video-dung").get(0).play();
      localStorage.setItem('Point', '10');
      $("#reOrder").prepend(
        '<div id="perfectAnswer"></div><div id="perfectButton"></div>'
      );
    }

  }

  //RenderCharacter

  function renderCharacter(response, word, correct) {
    let tagImg =
      '<img data-text="' +
      word.toUpperCase() +
      '"src="img/reorder/false - ' +
      word.toUpperCase() +
      '.svg"/>';
    let __char_correct = "";
    if (correct != null || correct != undefined) {
      __correct = correct ? "true" : "false";
      __char_correct = correct ? "___cha_true" : "___cha_false";
    }
    return (
      '<div class="___character_frame ' +
      __char_correct + ' __' + word.toUpperCase() +
      '" data="' +
      response +
      '"><span class="___character" data-text="' +
      word.toUpperCase() +
      '">' +
      word.toUpperCase() +
      "</span>" +
      //tagImg +
      "</div>"
    );
  }
});
