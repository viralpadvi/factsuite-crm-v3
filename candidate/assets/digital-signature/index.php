 <link href="css/bootstrap.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/signature-pad.css">

  <div id="signature-pad" class="signature-pad">
  	<h2 style="color:#000;">Signeture Demo</h2>
    <div class="signature-pad--body">
      <canvas></canvas>
    </div>
    <div class="signature-pad--footer">
      <div class="signature-pad--actions text-dark">
        <div>
          <button type="button" style="color: #000;" class="btn btn-secondary clear" data-action="clear">Clear</button>
          <button type="button" class="btn btn-success" style="display: none;" data-action="change-color">Change color</button>
          <button type="button" style="color: #000;" class="btn btn-secondary" data-action="undo">Undo</button>

        </div>
        <div>
          <button type="button" class="btn btn-success save" data-action="save-png">Save as PNG</button>
          <button type="button" class="btn btn-success save" data-action="save-jpg">Save as JPG</button>
          <button type="button" class="btn btn-success save" data-action="save-svg">Save as SVG</button>
        </div>
      </div>
    </div>
  </div>

  <script src="js/signature_pad.umd.js"></script>
  <script src="js/app.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script type="text/javascript">
  	var savePNGButton = wrapper.querySelector("[data-action=save-png]");
  	savePNGButton.addEventListener("click", function (event) {
  if (signaturePad.isEmpty()) {
    alert("Please provide a signature first.");
  } else {
    var dataURL = signaturePad.toDataURL('image/png');
    // download(dataURL, "signature.png");

    var canvas_img_data = canvas.toDataURL();
          var img_data = dataURL.replace(/^data:image\/(png|jpg);base64,/, "");
          //ajax call to save image inside folder
          $.ajax({
            url: 'save_sign.php',
            data: { img_data:img_data },
            type: 'post',
            dataType: 'json',
            success: function (response) {
               /*window.location ='';*/
               alert(JSON.stringify(response));
            }
          });
  }
});
  </script>
