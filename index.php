<?php
     
     require 'database.php';
     session_start();
     if ( !empty($_POST)) {
         // keep track validation errors
         $rutError = null;
         $pwdError = null;
          
         // keep track post values
         $rut = $_POST['rut'];
         $pwd = $_POST['pwd'];
          
         // validate input
         $valid = true;
         if (empty($rut)) {
             $rutError = 'Por favor ingrese RUT';
             $valid = false;
         }
          
         if (empty($pwd)) {
             $emailError = 'Por favor ingrese password';
             $valid = false;
         } 
         if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
             $sql = "SELECT * FROM cliente WHERE hashrut = ?";
             $q = $pdo->prepare($sql);
             $hashrut =  md5($rut);
             $hashpwd =  md5($pwd);
             var_dump($hashrut);
             $q->execute(array($hashrut));
             $result = $q->fetchAll();
            // die($result[0]['hashpwd']);
            $res_idcliente = $result[0]['idcliente'];
            $res_hashpwd = $result[0]['hashpwd'];
            Database::disconnect();
             if($res_hashpwd===$hashpwd)
             {
                $_SESSION['idcliente']=$res_idcliente;
                header("Location: menu.php");
             }
             else
             {
                header("Location: index.php");
             }

         }
     }
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>
 
<body>
    <div class="container">
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Banco Login</h3>
                    </div>
             
                    <form class="form-horizontal" action="index.php" method="post">
                      <div class="control-group <?php echo !empty($rutError)?'error':'';?>">
                        <label class="control-label">RUT</label>
                        <div class="controls">
                            <input name="rut" type="text"  placeholder="RUT" value="<?php echo !empty($rut)?$rut:'';?>">
                            <?php if (!empty($rutError)): ?>
                                <span class="help-inline"><?php echo $rutError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($pwdError)?'error':'';?>">
                        <label class="control-label">Password</label>
                        <div class="controls">
                            <input name="pwd" type="txt" placeholder="Password" value="<?php echo !empty($pwd)?$pwd:'';?>">
                            <?php if (!empty($pwdError)): ?>
                                <span class="help-inline"><?php echo $pwdError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Login</button>
                          <a class="btn" href="index.php">Back</a>
                          <a class="btn" href="create.php">Crear Usuario</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>