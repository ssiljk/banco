<?php
     
     require 'database.php';
  
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
            $hashrut =  md5($rut);
            $hashpwd =  md5($pwd);
             $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
             $sql = "INSERT INTO cliente (hashrut,hashpwd) values(?, ?)";
             $q = $pdo->prepare($sql);
             $q->execute(array($hashrut,$hashpwd));
             Database::disconnect();
             header("Location: index.php");
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
                        <h3>Crear un cliente</h3>
                    </div>
                    <form class="form-horizontal" action="create.php" method="post">
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
                          <button type="submit" class="btn btn-success">create</button>
                          <a class="btn" href="index.php">Back</a>
                        </div>
                    </form>     
                    
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>