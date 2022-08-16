<nav class="navbar navbar-dark bg-dark">

  <div class="container">
    <a class="navbar-brand" href="/eComerce/admin/dashboard.php"><?php echo lang('E-Commerce');?></a>
    <a class="navbar-brand " aria-current="page" href="../index.php" target="_blank"><?php echo lang('Go_shop');?></a>
      
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#app_nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="app_nav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      	 <li class="nav-item">
          <a class="nav-link " aria-current="page" href="dashboard.php"><?php echo lang('Home_Admin');?></a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link" href="categries.php"><?php echo lang('Categories_Site');?></a>
        </li>
         <li class="nav-item">
          <a class="nav-link " aria-current="page" href="Item.php"><?php echo lang('Items_Site');?></a>
        </li>
         <li class="nav-item">
          <a class="nav-link " aria-current="page" href="members.php"><?php echo lang('Member_site');?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link " aria-current="page" href="comments.php"><?php echo lang('comments_site');?></a>
        </li>
        
        
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Omar
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="members.php?do=edit&userid=<?php echo$_SESSION['ID']?>"><?php echo lang('Profile_Edit');?></a></li>
            <li><a class="dropdown-item" href="#"><?php echo lang('Setting_Site');?></a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="logout.php"><?php echo lang('Logout_Site');?></a></li>
          </ul>
        </li>
        
      </ul>
     
    </div> 
  </div>

</nav>

