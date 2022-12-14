<nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3 bg-gradient">
  <a class="navbar-brand" ><i class="bi bi-person-circle"></i> &nbsp;<?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';?></a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <?php if(isset($_SESSION['user_type']) && ($_SESSION['user_type'] == 1 || $_SESSION['user_type'] == 2)){?>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url(); ?>time_recording">Time Recording</a>
        </li>
      <?php } ?>
      <?php if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 1){?>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url(); ?>time_record">Employees Time Record</a>
        </li>
      <?php } ?>
      <?php if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 2){?>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url(); ?>time_record">Time Record</a>
        </li>
      <?php } ?>
      <?php if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 1){?>
        <li class="nav-item active">
          <a class="nav-link" href="<?php echo base_url(); ?>employee">Employee</a>
        </li>
      <?php } ?>
      <?php if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 1){?>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url(); ?>user">User</a>
        </li>
      <?php } ?>
      <?php if(isset($_SESSION['user_type']) && ($_SESSION['user_type'] == 1 || $_SESSION['user_type'] == 2)){?>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url(); ?>logout">Log out</a>
        </li>
      <?php } ?>
    </ul>
  </div>
</nav>