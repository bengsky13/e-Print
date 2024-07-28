<!DOCTYPE html>
<html>
  <head>
    <title>ePrint</title>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    />
  </head>
  <body class="bg-dark text-center text-light">
    <div class="container p-5">
      <div class="row justify-content-center">
        <div class="col-lg-10 border-light border-dotted" id="divFile">
          <div class="container p-5" id="qr">
           <h1 id="fileName"></h1>
          </div>
        </div>
      </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
<script>
            new QRCode(document.getElementById("qr"), "{{$qr}}");

</script>
  </body>
</html>
