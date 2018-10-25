$(document).ready(function (e) {
  let offset = 1;
  const img = document.getElementById('carousel');
  const rightBtn = document.getElementById('right-btn');
  const leftBtn = document.getElementById('left-btn');
  const firstImg = img.src;
  var movieId = document.getElementById("mynumber").value;
var gallery = [];
gallery.push(img.src);
var position = 1;

$("#right-btn").on('click',(function(e){
     $.ajax({
      url: 'phpForDisplayingPictureIntoGallery.php',
      type: "POST",
      data: {limit: offset, id:movieId},
      success: function(data){
        var picture = JSON.parse(data);
        gallery.push(picture[0]);

          if (data == 0) { // when I reach the last picture, I delete the array and again set there the first picture and showing it also reseting position and offset to start again
                          position = 1;
                          offset = 1;
                          gallery = [];
                          gallery.push(firstImg);
                          img.src = gallery[0];
                          console.log(gallery);

            } else {
                    img.src = gallery[position];
                    position++;
                  }
      }
    });

    offset += 1;

  }));
 });
