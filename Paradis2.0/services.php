<!doctype html>
<?php
    include "php/BDconection.php";
    include "php/InventoryDataHandler.php";

    $conn=connectToDatabase("LocalHost","root","","paradis");
    session_start();
    if(isset($_GET['id']))
    {
        $id=$_GET['id'];
    }
?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Untree.co">
  <link rel="shortcut icon" href="favicon.png">

  <meta name="description" content="" />
  <meta name="keywords" content="bootstrap, bootstrap4" />

		<!-- Bootstrap CSS -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
		<link href="css/tiny-slider.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
		<title>Paradis | <?php $itemData = searchInventoryItem($conn, $id);
                           if ($itemData !== null) echo $itemData->name;?></title>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var addButton = document.getElementById("add");
                addButton.addEventListener("click", function(event) {
                    event.preventDefault(); // Prevent the default button behavior

                    var id = "<?php echo $id; ?>"; // Use the PHP variable value
                    var quant = document.getElementById("quant").value; // Value from the input field

                    // Navigate to the URL
                    window.location.href = "php/CartDataHandler.php?id=" + id + "&quant=" + quant;
                });
            });
        </script>
	</head>

	<body>

		<!-- Start Header/Navigation -->
		<nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="Furni navigation bar">

			<div class="container">
                <a class="navbar-brand" href="index.php">
                    <img src="images/logoCMYK.png" alt="Paradis Logo">
                </a>

				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarsFurni">
					<ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
						<li class="nav-item">
							<a class="nav-link" href="index.php">Home</a>
						</li>
						<li><a class="nav-link" href="shop.php">Shop</a></li>
					</ul>

					<ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
                        <?php if(!isset($_SESSION['user'])){
                            echo '<li><a class="nav-link" href="../Login"><img src="images/user.svg"></a></li>';
                        }else{echo '<li><a class="nav-link" href="../Profile"><img src="images/user.svg"></a></li>';}?>
						<li><a class="nav-link" href="cart.php"><img src="images/cart.svg"></a></li>
					</ul>
				</div>
			</div>
				
		</nav>
		<!-- End Header/Navigation -->

		<!-- Start Hero Section -->
			<div class="hero">
				<div class="container">
					<div class="row justify-content-between">
						<div class="col-lg-5">
							<div class="intro-excerpt">
                                <?php
                                    if ($itemData !== null) {
                                        echo "<h1>" . $itemData->name . "</h1>";
                                    }
                                ?>
								<p class="mb-4"><?php echo($itemData->desc);?></p>
                                    <div class="input-group mb-3 d-flex align-items-center quantity-container" style="max-width: 120px;">

                                        <div class="input-group-prepend">
                                            <button style="padding: .375rem .75rem; padding-left: .0rem; background:none; border: none" class="btn btn-outline-black decrease" type="button">−</button>
                                        </div>
                                        <input style="border: none;border-radius: 25px;padding: 20px 10px" id="quant" type="number" class="form-control text-center quantity-amount" value="1" placeholder="" aria-label="HI!" aria-describedby="button-addon1">
                                        <div class="input-group-append">
                                            <button style="padding: .375rem .75rem;padding-right: .0rem; background:none; border: none" class="btn btn-outline-black increase" type="button">+</button>
                                        </div>
                                    </div>
								<p><a id="add" class="btn btn-secondary me-2">Adicionar ao carrinho</a><a href="#" class="btn btn-white-outline"><?php echo($itemData->price."€"); ?></a></p>
                            </div>
						</div>
						<div class="col-lg-7">
							<div class="hero-img-wrap">
                                <?php
                                echo('<img src="data:image/jpeg;base64,' . base64_encode($itemData->image) . '"class="img-fluid">');
                                ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		<!-- End Hero Section -->

		

		<!-- Start Why Choose Us Section -->
		<div class="why-choose-section">
			<div class="container">
				
				
				<div class="row my-5">
					<div class="col-6 col-md-6 col-lg-3 mb-4">
						<div class="feature">
							<div class="icon">
								<img src="images/truck.svg" alt="Image" class="imf-fluid">
							</div>
							<h3>Fast &amp; Free Shipping</h3>
							<p>Aproveite o nosso envio rápido e confiável para uma experiência de compra perfeita.</p>
						</div>
					</div>

					<div class="col-6 col-md-6 col-lg-3 mb-4">
						<div class="feature">
							<div class="icon">
								<img src="images/bag.svg" alt="Image" class="imf-fluid">
							</div>
							<h3>Easy to Shop</h3>
							<p>Experimente a conveniência de fazer compras fáceis com a nossa plataforma de fácil utilização.</p>
						</div>
					</div>

					<div class="col-6 col-md-6 col-lg-3 mb-4">
						<div class="feature">
							<div class="icon">
								<img src="images/support.svg" alt="Image" class="imf-fluid">
							</div>
							<h3>24/7 Support</h3>
							<p>Conte com o nosso apoio ininterrupto para qualquer assistência que necessite, 24 horas por dia, 7 dias por semana.</p>
						</div>
					</div>

					<div class="col-6 col-md-6 col-lg-3 mb-4">
						<div class="feature">
							<div class="icon">
								<img src="images/return.svg" alt="Image" class="imf-fluid">
							</div>
							<h3>Hassle Free Returns</h3>
							<p>Desfrute de devoluções sem complicações para uma experiência de compra sem preocupações.</p>
						</div>
					</div>



				</div>
			
			</div>
		</div>
		<!-- End Why Choose Us Section -->

		<!-- Start Product Section -->
		<div class="product-section pt-0">
			<div class="container">
				<div class="row">

					<!-- Start Column 1 -->
					<div class="col-md-12 col-lg-3 mb-5 mb-lg-0">
						<h2 class="mb-4 section-title">Descubra mais ofertas incríveis, disponíveis agora! Não perca tempo!</h2>
						<p class="mb-4">Aproveite enquanto o estoque dura!</p>
						<p><a href="#" class="btn">Ver mais</a></p>
					</div> 
					<!-- End Column 1 -->

                    <?php
                    $RandInventoryItems = searchRandomInventoryItems($conn,3);

                    foreach ($RandInventoryItems as $RItem)
                    {
                        echo '<div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">';
                        echo '<a class="product-item" href="services.php?id='.$RItem->id.'">';
                        echo '<img src="data:image/jpeg;base64,' . base64_encode($RItem->image) . '" class="img-fluid product-thumbnail">';
                        echo '<h3 class="product-title">'.$RItem->name.'</h3>';
                        echo '<strong class="product-price">'.$RItem->price.'€</strong>';
                        echo '<span class="icon-cross">';
                        echo '<img src="images/cross.svg" class="img-fluid">';
                        echo '</span>';
                        echo '</a>';
                        echo '</div>';
                    }
                    ?>

				</div>
			</div>
		</div>
		<!-- End Product Section -->

		<!-- Start Footer Section -->
		<footer class="footer-section">
			<div class="container relative">

				<div class="sofa-img">
					<img src="images/JorginFinal.png" alt="Image" class="img-fluid">
				</div>

				<div class="row">
					<div class="col-lg-8">
						<div class="subscription-form">
							<h3 class="d-flex align-items-center"><span class="me-1"><img src="images/envelope-outline.svg" alt="Image" class="img-fluid"></span><span>Subscribe to Newsletter</span></h3>

							<form action="#" class="row g-3">
								<div class="col-auto">
									<input type="text" class="form-control" placeholder="Enter your name">
								</div>
								<div class="col-auto">
									<input type="email" class="form-control" placeholder="Enter your email">
								</div>
								<div class="col-auto">
									<button class="btn btn-primary">
										<span class="fa fa-paper-plane"></span>
									</button>
								</div>
							</form>

						</div>
					</div>
				</div>

				<div class="row g-5 mb-5">
					<div class="col-lg-4">
						<div class="mb-4 footer-logo-wrap"><a href="#" class="footer-logo">Paradis</a></div>
						<p class="mb-4">Bem-vindo a Paradis, o destino definitivo para os fãs de anime! Neste site de venda exclusivo, mergulhe em um mundo vibrante e emocionante, onde sua paixão pelo anime é celebrada e atendida com uma variedade exuberante de produtos relacionados.</p>

						<ul class="list-unstyled custom-social">
							<li><a href="https://www.instagram.com/mario_v.s_04/"><span class="fa fa-brands fa-instagram"></span></a></li>
                            <li><a href="https://github.com/Cap-V-Prog"><span class="fa fa-brands fa-github"></span></a></li>
						</ul>
					</div>
				</div>

				<div class="border-top copyright">
					<div class="row pt-4">
						<div class="col-lg-6">
							<p class="mb-2 text-center text-lg-start">Copyright &copy;<script>document.write(new Date().getFullYear());</script>. All Rights Reserved. &mdash; Designed with love by <a href="#">Null Inc.</a>    </p>
						</div>

						<div class="col-lg-6 text-center text-lg-end">
							<ul class="list-unstyled d-inline-flex ms-auto">
								<li class="me-4"><a href="#">Terms &amp; Conditions</a></li>
								<li><a href="#">Privacy Policy</a></li>
							</ul>
						</div>

					</div>
				</div>

			</div>
		</footer>
		<!-- End Footer Section -->	


		<script src="js/bootstrap.bundle.min.js"></script>
		<script src="js/tiny-slider.js"></script>
		<script src="js/custom.js"></script>
	</body>

</html>
