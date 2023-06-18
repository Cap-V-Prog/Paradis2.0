<?php
include 'php/BDconection.php';
include 'php/InventoryDataHandler.php';
include 'php/CartDataHandler.php';
$conn = connectToDatabase("LocalHost", "root", "", "paradis");

include 'php/UsersDataHandler.php';
session_start();
if(!isset($_SESSION['user'])){
    header('location:../Login');
}
?>
<!doctype html>
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
		<title>Paradis | Cart</title>


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
						<li class="nav-item ">
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
								<h1>Cart</h1>
							</div>
						</div>
						<div class="col-lg-7">
							
						</div>
					</div>
				</div>
			</div>
		<!-- End Hero Section -->

		

		<div class="untree_co-section before-footer-section">
            <div class="container">
              <div class="row mb-5">
                <form id="form-container" class="col-md-12" action="php/updateCart.php" method="post">
                  <div class="site-blocks-table">
                    <table class="table">
                      <thead>
                        <tr>
                          <th class="product-thumbnail">Imagem</th>
                          <th class="product-name">Produto</th>
                          <th class="product-price">Preço</th>
                          <th class="product-quantity">Quantidade</th>
                          <th class="product-total">Total</th>
                          <th class="product-remove">Remover</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php

                      $subtotal = 0;

                      $userID = $_SESSION['user'];
                      $cartItems = searchCartByUserId($userID->id, $conn);

                      if (!empty($cartItems)) {
                          foreach ($cartItems as $cartItem) {
                              // Retrieve the item details based on the item ID in the cart
                              $itemData = searchInventoryItem($conn, $cartItem['I_ID']);

                              if ($itemData !== null) {
                                  // Display the item information in the desired HTML format
                                  echo '<tr>';
                                  echo '  <td class="product-thumbnail">';
                                  echo '    <img src="data:image/jpeg;base64,' . base64_encode($itemData->image) . '" alt="Image" class="img-fluid">';
                                  echo '  </td>';
                                  echo '  <td class="product-name">';
                                  echo '    <h2 class="h5 text-black">' . $itemData->name . '</h2>';
                                  echo '  </td>';
                                  echo '  <td>' . $itemData->price . '€</td>';
                                  echo '  <td>';
                                  echo '    <div class="input-group mb-3 d-flex align-items-center quantity-container" style="max-width: 120px;">';
                                  echo '      <div class="input-group-prepend">';
                                  echo '        <button class="btn btn-outline-black decrease" type="button">&minus;</button>';
                                  echo '      </div>';
                                  echo '      <input type="text" class="form-control text-center quantity-amount" name="products_' . $cartItem['I_ID'] . '" value="' . $cartItem['Quant'] . '" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">';
                                  echo '      <div class="input-group-append">';
                                  echo '        <button class="btn btn-outline-black increase" type="button">&plus;</button>';
                                  echo '      </div>';
                                  echo '    </div>';
                                  echo '  </td>';
                                  echo '  <td>' . $itemData->price * $cartItem['Quant'] . '€</td>';
                                  echo '  <td><a href="php/RemoveFromCart.php?id=' . $cartItem['I_ID'] . '" class="btn btn-black btn-sm">X</a></td>';
                                  echo '</tr>';
                              }
                              $subtotal += $itemData->price * $cartItem['Quant'];
                          }
                      } else {
                          echo '<tr>';
                          echo '  <td colspan="6">Não foi encontrado itens no seu carrinho</td>';
                          echo '</tr>';
                      }

                      ?>
                      </tbody>
                    </table>
                  </div>
                </form>
              </div>
        
              <div class="row">
                <div class="col-md-6">
                  <div class="row mb-5">
                    <div class="col-md-6 mb-3 mb-md-0">
                      <button id="submit-btn" class="btn btn-black btn-sm btn-block">Atualizar o carrinho</button>
                    </div>
                    <div class="col-md-6">
                      <button onclick="window.location='shop.php'" class="btn btn-outline-black btn-sm btn-block">Continuar a comprar</button>
                    </div>
                  </div>

                    <script>
                        document.getElementById('submit-btn').addEventListener('click', function() {
                            document.getElementById('form-container').submit();
                        });
                    </script>

                </div>
                <div class="col-md-6 pl-5">
                  <div class="row justify-content-end">
                    <div class="col-md-7">
                      <div class="row">
                        <div class="col-md-12 text-right border-bottom mb-5">
                          <h3 class="text-black h4 text-uppercase">Total do carrinho</h3>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col-md-6">
                          <span class="text-black">Subtotal (IVA 23%):</span>
                        </div>
                        <div class="col-md-6 text-right">
                          <strong class="text-black"><?php echo '' . $subtotal. '€'; ?></strong>
                        </div>
                      </div>
                      <div class="row mb-3">
                          <div class="col-md-6">
                              <span class="text-gray">Shipping:</span>
                          </div>
                          <div class="col-md-6 text-right">
                              <strong class="text-gray">10€</strong>
                          </div>
                      </div>
                      <div class="row mb-5">
                        <div class="col-md-6">
                            <span class="text-black"><strong>Total:</strong></span>
                        </div>
                        <div class="col-md-6 text-right">
                          <strong class="text-black"><?php if($subtotal>0) {echo '' . ($subtotal+10) . '€';}else{echo '0€';} ?></strong>
                        </div>
                      </div>
        
                      <div class="row">
                        <div class="col-md-12">
                          <button class="btn btn-black btn-lg py-3 btn-block" <?php if($subtotal>0){}else{echo 'disabled';}?> onclick="window.location='checkout.php'">Proceed To Checkout</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
		

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
