<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ePrint</title>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    />
    <style>
        .progress-container {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
        }
        .progress-label {
            margin-bottom: 10px;
            font-weight: bold;
        }
        .progress-bar {
            width: 100%;
            background-color: #e0e0e0;
            border-radius: 25px;
            overflow: hidden;
            position: relative;
            height: 30px; /* Adjust height for size */
        }
        .progress-bar-inner {
            height: 100%;
            background-color: black;
            width: 0%;
            border-radius: 25px 0 0 25px;
            text-align: center;
            color: white;
            line-height: 30px; /* Adjust line-height for size */
            position: relative;
            transition: width 0.25s;
        }
    </style>
</head>
<body class="bg-dark text-center text-light">
    <div class="container p-5">
      <div class="row justify-content-center">
      <div class="progress-container">
        <div class="progress-label">Processing:</div>
        <div class="progress-bar">
            <div class="progress-bar-inner" id="progressBarInner">0%</div>
        </div>
    </div>
      </div>
  </div>
    <script>
        function updateProgress(value) {
            console.log(value)
            const progressBarInner = document.getElementById('progressBarInner');
            progressBarInner.style.width = value + '%';
            progressBarInner.textContent = value + '%';
        }
        (async() => {
        // 
        while(true){
            try{
                let a = await fetch(window.location.href+"/colorStatus").then((result) => result.json())
                if(a.success == false){
                    console.log('error')
                }
                if(a.done == true){
                    console.log('done')
                }
                if(a.progress == 100){
                    break
                }
                updateProgress(a.progress);

            }
            catch(err){
                console.log(err)
            }
        }
        window.location.reload()
        })()

    </script>
</body>
</html>
