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
          <div class="container p-5">
           <img src="https://chart.googleapis.com/chart?cht=qr&chs=500x500&chld=L|0&chl={{$qr}}" class="w-100 img-fluid">
           <h1 id="fileName"></h1>
          </div>
        </div>
      </div>
  </div>

  </body>
</html>
