<?php
    
    //Variável recebe o diretório onde os arquivos estão armazenados
    $path =  '/var/www/html/semana-faeng/2016/download/';
    //Recebe via GET o número do CPF do usuário, vindo da DeclaracaoParticipacao.php
    $arquivo = $_GET['arquivo'];
    //Para CPF = 
    $string11 = $arquivo.'.pdf';
    // Retira caracteres especiais
    //$arquivo = filter_var($arquivo, FILTER_SANITIZE_STRING);
    // Retira qualquer ocorrência de retorno de diretório que possa existir, deixando apenas o nome do arquivo
    $string11 = basename($string11); 

    //Para CPFs que estão no BD e que contenham apenas 10 dígitos
    $string10 = substr($string11, 1,10); $string10 =  $string10.'.pdf';
    //Para CPFs que estão no BD e que contenham apenas 10 dígitos
    $string9 = substr($string11, 2,9);   $string9 =  $string9.'.pdf';

    // Contatena-se o diretório com o nome
    $caminho_download  = $path.$string11;
    $caminho_download2 = $path.$string10;
    $caminho_download3 = $path.$string9;

    // Verificação da existência do arquivo

    if (file_exists($caminho_download3)) {
        header('Content-type: octet/stream');
        // Indica o nome do arquivo como será "baixado". Você pode modificar e colocar qualquer nome de arquivo
        header('Content-disposition: attachment; filename="'.$arquivo.'.pdf";'); 
        // Indica ao navegador qual é o tamanho do arquivo
        header('Content-Length: '.filesize($caminho_download3));
        // Busca todo o arquivo e joga o seu conteúdo para que possa ser baixado
        readfile($caminho_download3);
        
    }else if (file_exists($caminho_download2)){
        header('Content-type: octet/stream');
        // Indica o nome do arquivo como será "baixado". Você pode modificar e colocar qualquer nome de arquivo
        header('Content-disposition: attachment; filename="'.$arquivo.'.pdf";'); 
        // Indica ao navegador qual é o tamanho do arquivo
        header('Content-Length: '.filesize($caminho_download2));
        // Busca todo o arquivo e joga o seu conteúdo para que possa ser baixado
        readfile($caminho_download2);
    }else if (file_exists($caminho_download)){
        header('Content-type: octet/stream');
        // Indica o nome do arquivo como será "baixado". Você pode modificar e colocar qualquer nome de arquivo
        header('Content-disposition: attachment; filename="'.$arquivo.'.pdf";'); 
        // Indica ao navegador qual é o tamanho do arquivo
        header('Content-Length: '.filesize($caminho_download));
        // Busca todo o arquivo e joga o seu conteúdo para que possa ser baixado
        readfile($caminho_download);
    }else{
        echo $caminho_download;
        die('Arquivo não existe!');
    }

            

   /*if (!file_exists($caminho_download)){
       echo $caminho_download;
       die('Arquivo não existe!');
   }
    header('Content-type: octet/stream');
    // Indica o nome do arquivo como será "baixado". Você pode modificar e colocar qualquer nome de arquivo
    header('Content-disposition: attachment; filename="'.$arquivo.'.pdf";'); 
    // Indica ao navegador qual é o tamanho do arquivo
    header('Content-Length: '.filesize($caminho_download));
    // Busca todo o arquivo e joga o seu conteúdo para que possa ser baixado
    readfile($caminho_download);*/

?>

