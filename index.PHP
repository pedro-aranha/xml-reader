
<?php 
if(isset($_POST['Enviar'])){
if(strlen($_FILES['file']['name']) > 0){
    $file = upload();
}else{
    echo "<script language='javascript' type='text/javascript'>alert('Adicione um arquivo para começarmos busca!');window.location.href='index.php';</script>";
}
$paths = searchPathAndValue($file); 

}
function upload(){

    $fileExtension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    if(in_array($fileExtension,['xml'])){

    $uploadfile = md5(basename($_FILES['file']['name']).time()).".xml";

    move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);

    }else{
        echo "<script language='javascript' type='text/javascript'>alert('Arquivo invalido! Use apenas arquivos xml');window.location.href='index.php';</script>";

    }
    $xml = file_get_contents($uploadfile);
    
    $toString = (array)simplexml_load_string($xml,'SimpleXMLElement',LIBXML_NOCDATA);
    
    $encodeXml = json_encode($toString);
    $xmlArray = json_decode($encodeXml, true);//  print_r($xmlArray);
    return $xmlArray;
}

function searchPathAndValue(array $file, $parentKey = '', $keys = [])
{  
    foreach ($file as $key => $value) {
        if (!empty($parentKey))
            $key = $parentKey . '/' . $key;

        if (is_array($value))
            return searchPathAndValue($value, $key, $keys);

      
        $keys[$key] = $value;
    }
    return $keys;
}


?> 
<!DOCTYPE html>
<html>

<head>
    <title>XML Reader!</title>
</head>
    <body>
        <link rel="stylesheet" href="style.css">
        <script src="scripts.js" defer></script> 
        <div>
            <form  method="post" enctype="multipart/form-data">
            
                <h1> XML READER</h1>
                <h7>Made by: Pedro Aranha</h7>
                <br><br>
                <div class="xmlUpload"> 
                    <input type="file" name="file">
                    
                    <button type="submit" name="Enviar" value="Enviar">Analisar</button>

                </div>
                <br><br>
        </div>
        
        </form>
        <div class="box-search">
            <input type="text"  id="myInput" onKeyUp="search()" placeholder="Search"></div>
            
            <div class="resultado" id="resultado"> 
        <table class="table table-bordered" id="myTable" width="25%" cellspacing="0">

        <?php
            if(isset($paths)) { ?> 
            <thead>

                <tr>
                    <th class="text-center">Chave</th>
                    <th class="text-center">Valor</th>
                </tr>
            </thead>

            <tbody id="myTable">
            <?php 
                foreach($paths as $key => $value){
                    ?>
                    <tr>
                    <td class="text-center"><?php echo $key; ?></td>
                    <td> <?php echo $value; ?></td>
                </tr>
            <?php 
            
            } ?>
            </tbody>

        </table><br><Br>

        <?php } ?> 
        </div>

   
    </body>
</html>
  