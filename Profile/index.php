<!DOCTYPE html>
<?php
include "../Paradis2.0/php/BDconection.php";
$conn = connectToDatabase("LocalHost", "root", "", "paradis");

include '../Paradis2.0/php/UsersDataHandler.php';
session_start();
if(!isset($_SESSION['user'])){
    header('location:../Login');
}
$user=$_SESSION['user'];
?>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Paradis | <?php echo($user->name); ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Paradis2.0/css/style.css">
    <link rel="shortcut icon" href="../Paradis2.0/favicon.png">
</head>
<body>
<nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="Furni navigation bar">

    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="../Paradis2.0/images/logoCMYK.png" alt="Paradis Logo">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsFurni">
            <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
                <li class="nav-item ">
                    <a class="nav-link" href="../Paradis2.0/index.php">Home</a>
                </li>
                <li><a class="nav-link" href="../Paradis2.0/shop.php">Shop</a></li>
            </ul>

            <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
                <li><a class="nav-link" href="#"><img src="../Paradis2.0/images/user.svg"></a></li>
                <li><a class="nav-link" href="../Paradis2.0/cart.php"><img src="../Paradis2.0/images/cart.svg"></a></li>
            </ul>
        </div>
    </div>

</nav>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous" />

<div class="container">
    <div class="row">
        <div class="col-12">
            <!-- Título da página -->
            <div class="my-5">
                <h3>O meu perfil</h3>
                <hr>
            </div>
            <!-- Formulário COMEÇO -->
            <form class="file-upload" method="post" action="../Paradis2.0/php/updateprofile.php">
                <div class="row mb-5 gx-5">
                    <!-- Detalhes de contato -->
                    <div class="col-xxl-8 mb-5 mb-xxl-0">
                        <div class="bg-secondary-soft px-4 py-5 rounded">
                            <div class="row g-3">
                                <h4 class="mb-4 mt-0">Detalhes de contato</h4>

                                <div class="col-md-12">
                                    <label class="form-label">Nome</label>
                                    <input name="name" type="text" class="form-control" placeholder="" aria-label="Primeiro nome" value="<?php echo $user->name;?>">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Número de telemóvel</label>
                                    <input name="tel" type="text" class="form-control" placeholder="" aria-label="Número de telefone" value="<?php echo $user->telephone;?>">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">NIF</label>
                                    <input name="nif" readonly type="text" class="form-control" placeholder="" aria-label="Número de telemóvel" value="<?php echo $user->nif;?>">
                                </div>

                                <div class="col-md-6">
                                    <label for="inputEmail4" class="form-label">Email</label>
                                    <input name="email" type="email" readonly class="form-control" id="inputEmail4" value="<?php echo $user->email;?>">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Morada</label>
                                    <?php if($user->address=='NULL'){
                                        echo '<input name="address" type="text" class="form-control" placeholder="Não definido" aria-label="Número de telemóvel" value="">';
                                    }else
                                    {
                                        echo '<input name="address" type="text" class="form-control" placeholder="" aria-label="Número de telemóvel" value="'.$user->address.'">';
                                    }?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Carregar foto de perfil -->
                    <div class="col-xxl-4">
                        <div class="bg-secondary-soft px-4 py-5 rounded">
                            <div class="row g-3">
                                <h4 class="mb-4 mt-0">Carregar sua foto de perfil</h4>
                                <div class="text-center">
                                    <!-- Carregar imagem -->
                                    <div class="square position-relative display-2 mb-3">
                                        <i class="fas fa-fw fa-user position-absolute top-50 start-50 translate-middle text-secondary"></i>
                                    </div>
                                    <!-- Botão -->
                                    <input type="file" id="customFile" name="file" hidden="">
                                    <label class="btn btn-success-soft btn-block" for="customFile">Carregar</label>
                                    <button type="button" class="btn btn-danger-soft">Remover</button>
                                    <!-- Conteúdo -->
                                    <p class="text-muted mt-3 mb-0"><span class="me-1">Nota:</span>Tamanho máximo 300px x 300px</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- Fim da linha -->

                <!-- Detalhes das redes sociais -->
                <div class="row mb-5 gx-5">
                    <!-- Alterar senha -->
                    <div class="col-xxl-6">
                        <div class="bg-secondary-soft px-4 py-5 rounded">
                            <div class="row g-3">
                                <h4 class="my-4">Alterar senha</h4>
                                <!-- Senha antiga -->
                                <div class="col-md-6">
                                    <label for="exampleInputPassword1" class="form-label">Senha antiga *</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1">
                                </div>
                                <!-- Nova senha -->
                                <div class="col-md-6">
                                    <label for="exampleInputPassword2" class="form-label">Nova senha *</label>
                                    <input type="password" class="form-control" id="exampleInputPassword2">
                                </div>
                                <!-- Confirmar senha -->
                                <div class="col-md-12">
                                    <label for="exampleInputPassword3" class="form-label">Confirmar senha *</label>
                                    <input type="password" class="form-control" id="exampleInputPassword3">
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- Fim da linha -->
                <!-- botão -->
                <div class="gap-3 d-md-flex justify-content-md-end text-center">
                    <button type="button" class="btn btn-danger btn-lg">Excluir perfil</button>
                    <button type="submit" class="btn btn-primary btn-lg">Atualizar perfil</button>
                </div>
                <div class="gap-3 d-md-flex justify-content-md-end text-center">
                    <P></P>
                </div>
            </form> <!-- Fim do formulário -->

        </div>
    </div>
</div>
</body>
</html>
