<?php
include 'header.php';
?>
<style>
  .dashboard {
    display: flex;
    flex-direction: column;
    gap: 20px;
  }

  header {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  header h2 {
    font-weight: 600;
    color: #333;
  }

  .cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 20px;
  }

  .card {
    background: #fff;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    transition: 0.3s;
  }

  .card:hover,
  .card:hover * {
    transform: translateY(-3px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    background: linear-gradient(135deg, #1e3c72, #2a5298);
    color: #fff;
  }

  .card h3 {
    color: #555;
    margin-bottom: 10px;
    font-size: 1rem;
  }

  .card p {
    font-size: 1.4rem;
    font-weight: 600;
    color: #1e3c72;
  }

  .earning {
    background: linear-gradient(135deg, #1e3c72, #2a5298);
    color: #fff;
  }

  .earning h3,
  .earning p {
    color: #fff;
  }

  .main-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 20px;
  }
</style>
<div class="dashboard">
  <header>
    <h2>Redes WiFi</h2>
  </header>
  <div class="cards">
    <div class="card">
      <h3>Parkimovil</h3>
      <!--<p><?php echo $total_impresion[0]; ?></p>-->
    </div>
    <!--<div class="card">
      <h3>CONTABILIDAD</h3>
      <p>hola mundo</p>
    </div>
    <div class="card">
      <h3>RECURSOS HUMANOS</h3>
    </div>
    <div class="card">
      <h3>ALMACÉN</h3>
    </div>-->
  </div>
</div>
<?php
include 'footer.php';
?>
<script>
  const Parkimovil = document.querySelector('.cards .card:nth-child(1)');
  Parkimovil.addEventListener('click', () => {
    Swal.fire({
      title: "WiFi Parkimovil",
      text: "conectado a la red Parkimovil",
      imageUrl: "imagenes/wifi_parkimovil.png",
      imageWidth: 400,
      imageHeight: 400,
      imageAlt: "Custom image"
    });
  });
</script>