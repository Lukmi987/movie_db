var textBox = document.getElementById('s');

var ajax= null;
textBox.onkeyup = function() { //happens when user realease button
  //value from searchbox and this refers to textBox
  var val= this.value;

  // remove space at the beginning and the end
  val = val.replace(/^\s|\s+$/, "");

  if(val !== '') {
    searForData(val);
  }
}

function searForData(value){
  //If an Ajax request is previously sent, it will be aborted because it isn't useful anymore.
  if(ajax && typeof ajax.abort === 'function'){
    ajax.abort();
  }

  // create ajax object
  ajax = new XMLHttpRequest();
  // the function will be executed on ready state is changed
  ajax.onreadystatechange = function() {
    if(this.readyState === 4 && this.status === 200) {
      try{
          var json = JSON.parse(ajax.responseText);
          console.log(json);
        } catch(e){
          return;
        }

        if(json.length === 0){
          return;
        } else {
          showMovies(json);
        }
    }
  }

  //open the connection
  ajax.open("GET","/movie_db/main/authentication/search.php?q="+ value,true);
  ajax.send();
}

function showMovies(movies) {
  //function to create a row for a result
  function createRow(rowMovie){
    var availableTutorials  = rowMovie;
    $(function() {
    availableTutorials;
          $( "#s" ).autocomplete({
             source: availableTutorials
          });
       });

  }
    createRow(movies);
}
