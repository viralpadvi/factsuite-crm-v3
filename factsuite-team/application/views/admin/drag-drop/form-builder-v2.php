<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css'>
<link rel='stylesheet' href='https://cdn.form.io/formiojs/formio.full.min.css'>
<script src='<?php echo base_url(); ?>assets/form-builder/dist/formio.full.min.js'></script>
<div id='formio'></div>
<div id="builder"></div>
<script type="text/javascript">
 const form = Formio.builder(document.getElementById('builder'), {}, {});

  form.on("change", function(e){
    console.log("Something changed on the form builder");
    var jsonSchema = JSON.stringify(form.submission, null, 4);
    console.log(jsonSchema); // this is the json schema of form components
});
</script>
<script type='text/javascript'>
  Formio.createForm(
    document.getElementById('formio'), 
    // 'https://examples.form.io/example'
  );


</script>