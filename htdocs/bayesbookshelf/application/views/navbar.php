<?php

  $isLoggedIn = false;
  $username = "My";

  if (!empty($this->session->userdata('member_id'))) {
    $isLoggedIn = true;
  } else if (! empty(get_cookie('member_login'))) {
    $isLoggedIn = true;
  }
  
  if($isLoggedIn){
      $len = strpos($this->session->userdata('member_id'),"@");
      $username = substr($this->session->userdata('member_id'),0,$len)."'s";
  }
  
/* 
  if (! empty($_SESSION["member_id"])) {
    $isLoggedIn = true;
  } else if (! empty($_COOKIE["member_login"]) && ! empty($_COOKIE["random_password"]) && ! empty($_COOKIE["random_selector"])) {
    $isLoggedIn = true;
    
        // Initiate auth token verification diirective to false
    $isPasswordVerified = false;
    $isSelectorVerified = false;
    $isExpiryDateVerified = false;
    
    // Get token for username
    $userToken = $auth->getTokenByUsername($_COOKIE["member_login"],0);
    
    // Validate random password cookie with database
    if (password_verify($_COOKIE["random_password"], $userToken[0]["password_hash"])) {
        $isPasswordVerified = true;
    }
    
    // Validate random selector cookie with database
    if (password_verify($_COOKIE["random_selector"], $userToken[0]["selector_hash"])) {
        $isSelectorVerified = true;
    }
    
    // check cookie expiration by date
    if($userToken[0]["expiry_date"] >= $current_date) {
        $isExpiryDateVerified = true;
    }
    
    // Redirect if all cookie based validation retuens true
    // Else, mark the token as expired and clear cookies
    if (!empty($userToken[0]["id"]) && $isPasswordVerified && $isSelectorVerified && $isExpiryDateVerified) {
        $isLoggedIn = true;
    } else {
        if(!empty($userToken[0]["id"])) {
            $auth->markAsExpired($userToken[0]["id"]);
        }
        // clear cookies
        $util->clearAuthCookie();
    } 
   
  } */
   

?>

<!--  
<script type="text/javascript" >
	$(document).ready( function() {
    	if(!window.location.hash) {
        	window.location = window.location + '#';
            window.location.reload();
         }
	});

</script>
-->
    
<nav class="navbar navbar-expand-xl bg-dark navbar-dark" >
  <a class="navbar-brand" href="<?php echo base_url('index.php/home');?>"><?php echo $username?> Bookshelf</a>

  <div class="col-5">
  <form class="form-inline" action="" style="margin:0;">
    <input class="form-control form-control-sm mr-sm-2" style="width:80%;" type="text" placeholder="Search">
    <button class="btn btn-success btn-sm" type="submit">Search</button>
  </form>
  </div>

  <div class="navbar-collapse justify-content-end">
    <ul class="navbar-nav">
    <?php 
      if(!$isLoggedIn){ ?>
    
      <li class="nav-item"><a class="nav-link" data-toggle="modal" data-target="#loginModal" href="#">
        <img src="<?php echo base_url('/resources/images/signin.png');?>" title="Sign in"></a></li>
      <li class="nav-item"><a class="nav-link" data-toggle="modal" data-target="#signupModal" href="#">
        <img src="<?php echo base_url('/resources/images/signup.png');?>" title="Sign up" ></a></li>
      <?php } else{?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Menu</a>
        <div class="dropdown-menu dropdown-menu-right text-center">
          <a class="dropdown-item" href="<?php echo base_url('index.php/managebook');?>">Manage</a>
          <a class="dropdown-item" href="<?php echo base_url('index.php/addbook');?>">Share</a>
          <a class="dropdown-item" href="<?php echo base_url('index.php/logout');?>">Logout</a>
        </div>
     </li> 
      <?php }?>   
    </ul>
  </div>
</nav>

  <!-- The Login Modal -->
  <div class="modal fade" id="loginModal">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Member Login</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body" style="background:#c4e7f7;">
          <form action="<?php echo base_url('index.php/login'); ?>" method="post" id="frmLogin">
            <div class="error-message"><?php if(isset($message)) { echo $message; } ?></div>
            <div class="field-group">
              <div>
                  <label for="login">Username</label>
              </div>
              <div>
                  <input class="form-control" name="member_name" type="email"
                      value="<?php if(isset($_COOKIE["member_login"])) { echo $_COOKIE["member_login"]; } ?>">
              </div>
            </div>

            <div class="field-group">
                <div>
                    <label for="password">Password</label>
                </div>
                <div>
                    <input class="form-control" name="member_password" type="password">
                </div>
            </div>

            <div class="field-group">
                <div>
                    <input type="checkbox" name="remember" id="remember" 
                        <?php if(isset($_COOKIE["member_login"])) { ?> checked
                        <?php } ?> /> <label for="remember-me">Remember me</label>
                </div>
            </div>
            <div class="field-group">
                <div>
                    <input type="submit" name="login" value="Login" class="btn btn-primary btn-block">
                </div>
            </div>
        </form>
        </div>
        
      </div>
    </div>
  </div>

    <!-- The Sign Up Modal -->
  <div class="modal fade" id="signupModal">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Join as Member</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body" style="background:#c4e7f7;">
          <form action="<?php echo base_url('index.php/signup'); ?>" method="post" >
            <div class="field-group">
              <div>
                  <label for="login">Email</label>
              </div>
              <div>
                  <input class="form-control" name="username" type="email" >
              </div>
            </div>

            <div class="field-group">
                <div>
                    <label for="pass">Password</label>
                </div>
                <div>
                    <input class="form-control" name="pass" type="password" >
                </div>
            </div>

            <div class="field-group" style="margin-bottom:5%;">
                <div>
                    <label for="pass2">Retype Password</label>
                </div>
                <div>
                    <input class="form-control" name="passconf" type="password">
                </div>
            </div>
            
            <div class="field-group">
                <div>
                    <input class="btn btn-primary btn-block" name="submit" type="submit"  value="Submit">
                </div>
            </div>
            </form>
        </div>
        
      </div>
    </div>
  </div>

