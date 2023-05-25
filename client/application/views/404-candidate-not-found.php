<?php extract($_GET);
$client_name = '';
if ($this->session->userdata('logged-in-client')) {
  $client_name = $this->session->userdata('logged-in-client')['client_name'];
}
$client_name = trim(str_replace(' ','-',$client_name));

$request_from = isset($request_from) ? $request_from : '';
$url = $this->config->item('my_base_url').$client_name.'/all-cases';
if ($request_from != '') {
  if (strtolower($request_from) == 'insuff-cases') {
    $url = $this->config->item('my_base_url').$client_name.'/insuff-cases';
  } else if (strtolower($request_from) == 'client-clarification') {
    $url = $this->config->item('my_base_url').$client_name.'/client-clarification-cases';
  }
}
?>
<h1 class="m-0 text-dark">
  <?php if(isset($param) && $param != '') {
    $url = $this->config->item('my_base_url').$client_name.'/selected-report-cases?param='.$param;
  } ?>
  <a class="pr-3" href="<?php echo $url;?>">
    <img src="<?php echo base_url()?>assets/client/assets-v2/dist/img/arrow-right.svg"></a>No Candidate Found</h1>
          </div>
        </div>
      </div>
    </div>