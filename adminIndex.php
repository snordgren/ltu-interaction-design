<!DOCTYPE html>
<html lang="sv">

<head>
  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Bothniabladet</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/styles.css">
   <link rel="stylesheet" href="./css/modalStyles.css"> 

</head>

<body>
  <!-- Inkluderar projektfiler -->
  <?php include 'modal.php'; ?>
  <?php include 'modalConfirm.php'; ?>
  <script type="text/javascript" src="image.js"></script>



  <!-- START of webbpage -->


  <div class="jumbotron jumbotron-fluid">
    <h1 style="background-color:#7ABDFF; color:#FFFFFF; font-family:Courier New, Courier, monospace;">
      <p class="text-center"> Bothniabladets Bildbyrå <p>
    </h1>

    <div class="navContainer container d-flex justify-content-center">

      <ul class="nav nav-pills">

        <li class="nav-item mx-2">
          <a class="nav-link active" href="./adminIndex.php"><b>Sök</b></a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link" href="./laddaUppBild.php"><b>Ladda upp</b></a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link" href="./orderhantering.php"><b>Orderhantering </b></a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link" href="./minaSidor.php"><b>Mina sidor</b></a>
        </li>

      </ul>
    </div>

  </div>
  
  <div class="container col-lg-8 col-md-6 col-sm-12">
  <hr>
    <div class="d-flex justify-content-center">
      <h2> Sök </h2>
    </div>
    <div class="container">


      <div class="d-flex justify-content-center">

        <form action="">
          <!-- Vid "onkeyup" så körs funktionen showImages med inparamentern = värdet man skrivit -->
          <input type="text" class="txt1 md-autocomplete" id="txt1" size="50" placeholder="Skriv sökord separerat med mellanslag.." onkeyup="showImages(this.value)">
        </form>


      </div>

      <div class="d-flex justify-content-center">
        <p> <b> Bästa träffar: </p> </b> &nbsp; <p id="txtSuggestion"> </p>
      </div>
      <hr>
      <!-- Jumbotron ends -->
    </div>

    <!-- I denna div så visas bild-resultaten -->
    <div class="row text-center d-flex justify-content-center" id="imgSuggestion">

    </div>

    <!-- Container ends -->
  </div>



  <!-- END of webbpage -->

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>

</html>