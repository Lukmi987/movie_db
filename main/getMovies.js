var xhr = new XMLHttpRequest();
xhr.open('GET', 'moviesData.json',true);
xhr.onreadystatechange = function () {
  if (xhr.readyState === 4) {
    var moviesPage = document.getElementById('movies-data');
    var role = moviesPage.dataset.role;
    var userId = moviesPage.dataset.userid;
    var movies = JSON.parse(xhr.responseText);
    var statusHTML = '<tr>';
    for(var i=0; i<movies.length; i+=1){
      statusHTML += '<td>';
      statusHTML += movies[i].title;
      statusHTML += '</td>';
      statusHTML += '<td>';
      statusHTML += movies[i].description;
      statusHTML += '</td>';
      statusHTML += '<td>';
      statusHTML += movies[i].release_year;
      statusHTML += '</td>';
      statusHTML += '<td>';
      statusHTML += movies[i].length;
      statusHTML += '</td>';
       // check if logged user is the owner of the movie
        if((movies[i].Owner_id == userId) || role == 1){
      statusHTML += '<td>';
      statusHTML += '<a href="UpdateMovie.php?id=';
      statusHTML += movies[i].film_id;
      statusHTML += ' ">Update</a>';
      statusHTML += '</td>';
      statusHTML += '<td>';
      statusHTML += '<a href="DeleteMovie.php?id=';
      statusHTML += movies[i].film_id;
      statusHTML += ' ">Delete</a>';
      statusHTML += '</td>';}
      statusHTML += '</tr>';
    }
    document.getElementById('listOfMoviesBody').innerHTML = statusHTML;
  }
};
xhr.send();
