<?php

require_once './application/libraries/Encrypt.php';
   
$encrypt = new Encrypt();

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Edição</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js" integrity="sha384-pjaaA8dDz/5BgdFUPX6M/9SUZv4d12SUPF0axWc+VRZkx5xU3daN+lYb49+Ax+Tl" crossorigin="anonymous"></script>
    <script src="main.js"></script>
</head>
<body>

<div class="container">

<h1> Edição de Pessoa </h1>


<?php echo form_open_multipart('http://recrutamento.ci.lab06.dev.iesde.com.br/products/update/'.$encrypt->crypt($data->PessoaID, 'e')); ?>

  <?php
    $csrf = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
    );
    ?>
    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />

  Nome:<br>
  <input class="form-control" type="text" placeholder="Nome" name="nome" value="<?php echo $data->Nome; ?>" required >
  <?php echo form_error('nome', '<div class="error">', '</div>'); ?>
  <br>
  Sobrenome:<br>
  <input class="form-control" type="text" placeholder="Sobrenome" name="sobrenome" value="<?php echo $data->Sobrenome; ?>" required>
  <?php echo form_error('sobrenome', '<div class="error">', '</div>'); ?>
  <br>
  E-mail:<br>
  <input class="form-control" type="email" name="email" placeholder="E-mail" value="<?php echo $data->Email; ?>" required>
  <?php echo form_error('email', '<div class="error">', '</div>'); ?>
  <br>
  Nova Senha:<br>
  <input class="form-control" type="password" name="senha" placeholder="Senha" value="<?php echo $data->Senha; ?>" required>
  <?php echo form_error('senha', '<div class="error">', '</div>'); ?>
  <br>
  Confirmar Nova Senha:<br>
  <input class="form-control" type="password" name="confsenha" placeholder="Confirme a senha" value="<?php echo $data->Senha; ?>" required>
  <?php echo form_error('confsenha', '<div class="error">', '</div>'); ?>
  <br>
  Estado:<br>
  <select class="form-control" name="estado" required>
    <?php foreach ($estados as $d) { ?>      

        <?php if($data->EstadoID == $d['EstadoID']) { ?>
          <option value="<?php echo $d['EstadoID']; ?>" selected> <?php echo $d['Sigla']; ?> </option>
        <?php } ?>
        <?php if($data->EstadoID != $d['EstadoID']) { ?>
          <option value="<?php echo $d['EstadoID']; ?>"> <?php echo $d['Sigla']; ?> </option>
        <?php } ?>
          
      <?php } ?>
  </select>
  <?php echo form_error('estado', '<div class="error">', '</div>'); ?>
  <br>
  Cidade:<br>
  <input class="form-control" type="text" name="cidade" placeholder="Cidade" value="<?php echo $data->Cidade; ?>" required>
  <?php echo form_error('cidade', '<div class="error">', '</div>'); ?>
  <br>
  <input type="hidden" value="<?php echo $data->Foto; ?>" name="foto">
  Foto:<br>
  <input type="file" name="foto"><br>
  <?php if($data->Foto == 'sem foto') {?>
      <small>Nenhuma foto enviada ainda!</small>
      <br>
  <?php } ?>
  <?php if($data->Foto != 'sem foto') {?>
      <small>Foto já enviada!</small>
      <br>
  <?php } ?>
  <br>
  <button class="btn btn-success" type="submit" value="Submit"> Enviar </button>
  <a href="http://recrutamento.ci.lab06.dev.iesde.com.br/products" class="btn btn-info"> Listar </a>
<?php echo form_close()?> 

</div>
<br>
</body>
</html>