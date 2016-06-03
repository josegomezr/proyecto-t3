<?php $this->load->view('admin/layout/header'); ?>
<?php $this->load->view('admin/layout/sidebar'); ?>
<link rel="stylesheet" href="<?php echo base_url('components/pdfjs-dist/web/pdf_viewer.css') ?>">

<!-- cuerpo -->
<div class="col-xs-12 col-sm-8 col-md-9" id="main_content">
    <div class="pull-right">
        <a href="<?php echo $url ?>" class="btn btn-default" target="_blank">Abrir Fuera <i class="fa fa-external-link"></i></a>
    </div>
    <br class="clearfix">
    <br>
    <div class="row clearfix">
        <object src="<?php echo $url ?>" class="col-xs-12">
            <embed src="<?php echo $url ?>" class="col-xs-12" height="500px"></embed>
        </object>
    </div>
</div>
<!-- 

<script src="<?php echo base_url('components/pdfjs-dist/build/pdf.js') ?>"></script>
<script src="<?php echo base_url('components/pdfjs-dist/web/pdf_viewer.js') ?>"></script>

<script>
    var base = '<?php echo base_url(); ?>'
    var ruta = ''
</script>
<script>
    $(function(){

  //
  // Disable workers to avoid yet another cross-origin issue (workers need
  // the URL of the script to be loaded, and dynamically loading a cross-origin
  // script does not work).
  //
  // PDFJS.disableWorker = true;

  //
  // The workerSrc property shall be specified.
  //
  PDFJS.workerSrc = base+'components/pdfjs-dist/build/pdf.worker.js';

  //
  // Asynchronous download PDF
  //
  PDFJS.getDocument(ruta).then(function getPdfHelloWorld(pdf) {
    //
    // Fetch the first page
    //
    pdf.getPage(1).then(function getPageHelloWorld(page) {
      var scale = 1.5;
      var viewport = page.getViewport(scale);

      //
      // Prepare canvas using PDF page dimensions
      //
      var canvas = document.getElementById('viewer');
      var context = canvas.getContext('2d');
      canvas.height = viewport.height;
      canvas.width = viewport.width;

      //
      // Render PDF page into canvas context
      //
      var renderContext = {
        canvasContext: context,
        viewport: viewport
      };
      page.render(renderContext);
    });
  });
    })
</script> -->
<?php $this->load->view('admin/layout/footer'); ?>