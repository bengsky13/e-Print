<!DOCTYPE html>
<html>
  <head>
    <title>ePrint</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <style>
      @import url(https://fonts.googleapis.com/css?family=Open+Sans:700,300);

      .custom-iframe {
        width: 100%;
        height: 600px;
        overflow-y: auto;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      }

      .border-dotted {
        border: 4px dashed #ffffff !important;
        border-radius: 20px;
      }
    </style>
  </head>
  <body class="bg-dark text-light">
    <div class="container p-5">
      <div class="row justify-content-center">
        <div class="col-lg-10">
        <div id="pdf-viewer" class="custom-iframe"></div>
        </div>
      </div>
      <div class="row">
        <div class="container">
          <h1 class="text-center">Detail</h1>
          <div class="row">
            <div class="col">
              <h4 class="card-title">Total Page</h4>
              <h4 class="card-title">Color Detected</h4>
              <h4 class="card-title">Print full black</h4>
              <h4 class="card-title">Print with color</h4>
              <a href="/print/{{$id}}/payment?type=1"><button class="btn btn-success btn-lg">PRINT BLACK</button></a>

            </div>
            <div class="col">
              <h4 class="card-title">{{$total}}</h4>
              <h4 class="card-title">{{$total_colored}} Page's</h4>
              <h4 class="card-title">Rp{{number_format($bnw)}}</h4>
              <h4 class="card-title">Rp{{number_format($colored)}}</h4>
              <a href="/print/{{$id}}/payment?type=2"><button class="btn btn-danger btn-lg">PRINT COLOR</button></a>
            </div>
          </div>
        </div>
      </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
<script>
    var url = '/uploads/{{$id}}/file.pdf#toolbar=0&navpanes=0';
    var pdfjsLib = window['pdfjs-dist/build/pdf'];

pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js';

pdfjsLib.getDocument(url).promise.then(function(pdf) {
    var viewer = document.getElementById('pdf-viewer');

    for (var pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
        pdf.getPage(pageNum).then(function(page) {
            var scale = 1.5;
            var viewport = page.getViewport({scale: scale});

            var canvas = document.createElement('canvas');
            canvas.className = 'w-100';
            var context = canvas.getContext('2d');
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            viewer.appendChild(canvas);

            var renderContext = {
                canvasContext: context,
                viewport: viewport
            };
            page.render(renderContext);
        });
    }
});
</script>
  </body>
</html>