<?php
include 'header.php'
?>
<button class="tablink" onclick="openPage('Home', this, 'white')" id="defaultOpen">Inventario</button>
<button class="tablink" onclick="openPage('News', this, 'white')">News</button>
<button class="tablink" onclick="openPage('Contact', this, 'white')">Contact</button>
<button class="tablink" onclick="openPage('About', this, 'white')">About</button>

<div id="Home" class="tabcontent">
  <div class="container">
    <?php
    $myarray = ["brother ventas", "Kyocera recepcion", "brother ventas", "Kyocera recepcion"];
    for ($i = 0; $i < count($myarray); $i++) {

    ?>
      <div class="card" style="cursor: pointer;">
        <center><img src="imagenes/chek.png" alt="Avatar" style="width:100px"></center>
        <div class="container">
          <h4><b><?php echo $myarray[$i]; ?></b></h4>
          <p>existencias: 80pz</p>
        </div>
      </div>
    <?php
    }
    ?>
  </div>
</div>




<!--<div class="container">
    <div class="card" style="cursor: pointer;">
      <center><img src="imagenes/chek.png" alt="Avatar" style="width:100px"></center>
      <div class="container">
        <h4><b>Toner Brother Recepción</b></h4>
        <p>Existencias:28</p>
      </div>
    </div>
    <div class="card" style="cursor: pointer;">
      <center><img src="imagenes/chek.png" alt="Avatar" style="width:100px"></center>
      <div class="container">
        <h4><b>Toner Brother Recepción</b></h4>
        <p>Existencias:28</p>
      </div>
    </div>
  </div>

</div>-->

<div id="News" class="tabcontent">
  <!--<div>
    <canvas id="myChart"></canvas>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
      type: 'pie',
      data: {
        labels: ['4', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
          label: '# of Votes',
          data: [12, 19, 3, 5, 2, 3],
          borderWidth: 1,
        }]
      },
      options: {
        aspectRatio: 3.0,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>-->
</div>

<div id="Contact" class="tabcontent">
  <h3>Contact</h3>
  <p>Get in touch, or swing by for a cup of coffee.</p>
</div>

<div id="About" class="tabcontent">
  <h3>About</h3>
  <p>Who we are and what we do.</p>
</div>

<?php
include 'footer.php'
?>