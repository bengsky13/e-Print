<!DOCTYPE html>
<html>
  <head>
    <title>ePrint</title>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    />
    <style>
        @import url(https://fonts.googleapis.com/css?family=Open+Sans:700,300);



.border-dotted {
      border: 4px dashed #ffffff !important;
      border-radius: 20px;
    }
    </style>
  </head>
  <body class="bg-dark text-center text-light">
    <div class="container p-5">
      <div class="row justify-content-center">
        <div class="col-lg-10 border-light border-dotted" id="divFile">
          <div class="container p-5">
           <img src="/upload.svg" class="w-100 img-fluid">
           <h1 id="fileName"></h1>
          </div>
        </div>
      </div>

      <div class="row justify-content-center p-5">
        <form action="{{$id}}/upload" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" id="inputUpload" class="d-none" accept="application/pdf" name="file" required>
        <button class="btn btn-success btn-lg" id="btn" disabled>Upload</button>
        </form>
        </div>
  </div>

  <script>
    const divFile = document.getElementById('divFile')
    const button = document.getElementById('btn')
    const inputUpload = document.getElementById('inputUpload');
    divFile.addEventListener("click", function()
    {
      inputUpload.click();
    })

    inputUpload.addEventListener('change', function() {
      const file = inputUpload.files[0];
      if (file && file.type === 'application/pdf') {
        document.getElementById("fileName").innerHTML = file.name;4
        button.disabled = false;
      } else {
        window.location.reload()
      }
    });
  </script>
  </body>
</html>
