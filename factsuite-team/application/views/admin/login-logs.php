<!--Content-->
<section id="pg-hdr">
   <div class="container-fluid">
      
    </div>
  </div>
</section>
<section id="pg-cntr">
  <div class="pg-hdr">
     <!--Nav Tabs-->
     <!--  <div id="FS-candidate-mn" class="add-team">
        <ul class="nav nav-tabs nav-justified">
            
           <li class="nav-item">
              <a class="nav-link active" href="<?php echo $this->config->item('my_base_url').'component'; ?>">Component</a>
           </li>
           <li class="nav-item">
              <a class="nav-link" href="<?php echo $this->config->item('my_base_url').'package'; ?>">Package</a>
           </li>
           <li class="nav-item">
              <a class="nav-link " href="<?php echo $this->config->item('my_base_url').'factsuite-admin/factsuite-alacarte'; ?>">Alacarte</a>
           </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo $this->config->item('my_base_url').'role'; ?>">Role</a>
           </li>
        </ul>
      </div> -->
     <!--Nav Tabs-->
  </div>
  <div class="pg-cnt">
     <div id="FS-candidate-cnt" class="FS-candidate-cnt">
         
         <div class="row">
             <div class="col-md-9">
                 <h3>Login Log Details</h3>
             </div>
             <div class="col-md-3">
                Login Logs Filter
                <?php 
               $roles = $this->db->get('roles')->result_array();
               $fltr = isset($_GET['filter']) ? $_GET['filter'] : '';
               $admin = '';
                $candidate = '';
                $client = '';
               if ($fltr=='admin') {
                    $admin = 'selected'; 
               }else if($fltr=='candidate'){ $candidate = 'selected'; }else if($fltr=='client'){ $client = 'selected'; }
                ?>
                 <select class="form-control" id="get-log-filter">
                     <option value="">ALL</option> 
                     <option <?php echo $admin; ?> value="admin">Admin</option> 
                     <?php 
                     if (count($roles) > 0) {
                         foreach ($roles as $k => $val) {
                            $select = '';
                            if ($fltr==strtolower($val['role_name'])) {
                                    $select = 'selected'; 
                               }
                             echo "<option ".$select." value='".strtolower($val['role_name'])."'>".$val['role_name']."</option>";
                         }
                     }
                     ?>
                     <option <?php echo $client; ?> value="client">Client</option>
                     <option <?php echo $candidate; ?> value="candidate">Candidate</option>
                 </select>
             </div>
         </div>
        
        <div class="table-responsive mt-3" id="">
          <table class="table-fixed datatable table table-striped">
            <thead class="table-fixed-thead thead-bd-color">
              <tr>
                <th>Sr No.</th> 
                <th>User&nbsp;Name</th> 
                <th>User Email</th>  
                <th>Role</th>  
                <th>Login IP</th>  
                <th>Login Time</th>   
              </tr>
            </thead>
            <tbody class="table-fixed-tbody tbody-datatable"> 
              <?php  
              if (count($logs) > 0) {
                $i = 1;
                foreach ($logs as $key => $value) {
                    ?>

                <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $value['userName']; ?></td>
                <td><?php echo $value['email']; ?></td>
                <td><?php echo $value['role']; ?></td> 
                <td><?php echo $value['ipAddress']; ?></td>

                <td><?php echo date($selected_datetime_format['php_code'],strtotime($value['timeDate'])); ?></td> 
                </tr>
                <?php
                }
              }
              ?>
            </tbody>
          </table>
        </div>
        <!--View Team Content-->
     </div>
  </div>
  <script>
      $("#get-log-filter").on('change',function(){
        window.location.href = base_url+'factsuite-admin/login-logs/?filter='+$(this).val();
      });
  </script>
 