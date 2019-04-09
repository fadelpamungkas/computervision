<?php
    $url = $_POST['url'];
    echo '<script type="text/javascript">',
         'processImage();',
         '</script>'
    ;
?>

<!DOCTYPE html>
    <html>
    <head>
        <title>Analyze Sample</title>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    </head>
    <body>
     
    <script type="text/javascript">
        $(document).ready(function processImage() {
            var subscriptionKey = "9b995d750b7b4a9a9ba09f3a0513288b";
            var uriBase =
                "https://southeastasia.api.cognitive.microsoft.com/vision/v2.0/analyze";
    
            var params = {
                "visualFeatures": "Categories,Description,Color",
                "details": "",
                "language": "en",
            };
     
            var sourceImageUrl = "<?php echo $url ?>";
            document.querySelector("#sourceImage").src = sourceImageUrl;
     
            $.ajax({
                url: uriBase + "?" + $.param(params),
     
                beforeSend: function(xhrObj){
                    xhrObj.setRequestHeader("Content-Type","application/json");
                    xhrObj.setRequestHeader(
                        "Ocp-Apim-Subscription-Key", subscriptionKey);
                },
     
                type: "POST",
    
                data: '{"url": ' + '"' + sourceImageUrl + '"}',
            })
     
            .done(function(data) {
                $("#responseTextArea").val(JSON.stringify(data, null, 2));
                $("#overview").text(data.description.captions[0].text);
            })
     
            .fail(function(jqXHR, textStatus, errorThrown) {
                var errorString = (errorThrown === "") ? "Error. " :
                    errorThrown + " (" + jqXHR.status + "): ";
                errorString += (jqXHR.responseText === "") ? "" :
                    jQuery.parseJSON(jqXHR.responseText).message;
                alert(errorString);
            });
        });
    </script>
    <div id="wrapper" style="width:1020px; display:table;">
        <div id="jsonOutput" style="width:600px; display:table-cell;">
            <br><br>
            <br><br>
            <textarea id="responseTextArea" class="UIInput"
                      style="width:580px; height:400px;"></textarea>
        </div>
        <div id="imageDiv" style="width:420px; display:table-cell;">
            <br><br>
            <br><br>
            <img id="sourceImage" width="400" />
            <br>
            <h1 id="overview">Overview</h1>
        </div>
    </div>
    </body>
</html>
