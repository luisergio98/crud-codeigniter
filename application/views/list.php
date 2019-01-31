<?php 
    
require_once './application/libraries/Encrypt.php';
   
$encrypt = new Encrypt();

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Listar</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js" integrity="sha384-pjaaA8dDz/5BgdFUPX6M/9SUZv4d12SUPF0axWc+VRZkx5xU3daN+lYb49+Ax+Tl" crossorigin="anonymous"></script>
        <script src="main.js"></script>
    </head>
    <body>
        <div class="container-fluid">
            <h1> Lista de Pessoas </h1>
            <div class="table-responsive">
                <?=$busca;?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Ícone</th>
                            <th>Nome</th>
                            <th>Sobrenome</th>
                            <th>Email</th>
                            <th>Senha</th>
                            <th>Estado</th>
                            <th>Cidade</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($data)) { ?>
                            <?php foreach ($data as $d) { ?>      
                                <tr>
                                    <td><img heigth="30" width="30" src="<?php echo $d['Foto']; ?>"></td>
                                    <td><?php echo $d['Nome']; ?></td>
                                    <td><?php echo $d['Sobrenome']; ?></td>  
                                    <td><?php echo $d['Email']; ?></td>
                                    <td><?php echo $d['Senha']; ?></td>


                                <?php foreach ($estados as $e) { ?>      

                                        <?php if ($d['EstadoID'] == $e['EstadoID']) { ?>
                                            <td> <?php echo $e['Sigla']; ?> </td>

                                        <?php } ?>

                                <?php } ?>


                                    <td><?php echo $d['Cidade']; ?></td>
                                    <td><a href="http://recrutamento.ci.lab06.dev.iesde.com.br/products/edit/<?php echo $encrypt->crypt($d['PessoaID'], 'e'); ?>"><i class="fa fa-pencil"></i>&nbsp;Editar</a></td>
                                    <td><a href="http://recrutamento.ci.lab06.dev.iesde.com.br/products/delete/<?php echo $encrypt->crypt($d['PessoaID'], 'e');; ?>"><i class="fa fa-trash-o"></i>&nbsp;Remover</a></td>     
                                </tr>
                                
                            <?php } ?>
                     <?php } ?>

                        <?php
                        if (empty($data)) {
                            echo "<br><h2> Nenhum registro encontrado por favor cadastre um usuário. </h2><br>";
                        }
                        ?>

                    </tbody>
                </table>
                &nbsp;<a class="btn btn-info" href="http://recrutamento.ci.lab06.dev.iesde.com.br/products/create">Cadastrar</a>
            </div>
            <br>
            <?php echo form_open('http://recrutamento.ci.lab06.dev.iesde.com.br/products/buscar'); ?>

            <h2> Pesquisar </h2>

            <?php
            $csrf = array(
                    'name' => $this->security->get_csrf_token_name(),
                    'hash' => $this->security->get_csrf_hash()
            );
            ?>
            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />

            <input style="width: 50% !important;" class="form-control" type="text" name="pesquisa" placeholder="Pesquisar ..." required>  
            <?php echo form_error('pesquisa', '<div class="error">', '</div>'); ?>

            <br>
            &nbsp;  <button style="float: left !important" class="btn btn-warning" type="submit" value="Submit"> Enviar </button>
            &nbsp;  <a class="btn btn-info" href="http://recrutamento.ci.lab06.dev.iesde.com.br/products/">Limpar Pesquisa</a>

            <?php echo form_close() ?> 

        </div>
        <br>
    </body>
</html>