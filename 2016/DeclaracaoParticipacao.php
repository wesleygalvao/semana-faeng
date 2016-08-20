
 <!-- Script em PHP para busca do CPF no Banco de Dados  -->
<?php
// Verifica se houve POST e se o usuário ou a senha é(são) vazio(s)   
     
    if(!empty($_POST) AND (empty($_POST['cpf']))) { 
     header("Location:DeclaracaoParticipacao.php");
   }
    //Inicialização de variáveis
    $id_connection = ''; // Recebe o status de conexão
    $cpf = ''; //Recebe o valor do input submetido no formulávia via POST
    $cpfcopy = ''; //Recebe uma cópia da varíavel $cpf
    $sql = ''; //Recebe o comando sql
    $query = ''; //Recebe o valor da query sql
    $count = 0; //Recebe o número de tuplas encontradas na query 
    $row = ''; //
    $output = 0;//Recebe um valor para determinar a saída na impressão da tela
    $alert = '';//Rebece um código HTML para alerta. 

    // Tenta se conectar ao servidor MySQL
    $id_connection = mysql_connect('localhost', 'root', '12345678') or trigger_error(mysql_error());
    // Tenta se conectar a um banco de dados MySQL
    mysql_select_db('semanafaeng') or trigger_error(mysql_error());      
    //Variável guarda o valor recebido pelo o input.
    $cpf = $_POST['cpf'];

    /*Função substr(string, start,length) : Neste caso a função 'corta' nos dois primeiros dígitos 
    do CPF, geralmente são os dígitos que contém '0' e retorna uma string de tamanho 9. Esta string resultante
    será usada na busca pelo o CPF no BD  */
    $cpfcopy = substr($cpf, 2,9);
   
    /*Função que verifica se o tamanho do input recebido é menor que 11(CFP possui 11 dígitos),
    e acrescenta o dígito '0' à esquerda da string até que o seu tamanho senha == 11.
    if(strlen($cpfcopy) < 11){//Se o comprimento da string for menor que 11
      //Então, adicione o dígito '0' à esquerda até que a string tennha tamanho 11;
      $cpfcopy = str_pad($cpfcopy,11,"0000", STR_PAD_LEFT);
    }
    echo $cpfcopy;
    */

    #$senha = mysql_real_escape_string($_POST['070194']);
    
    // Validação do usuário/senha digitados
    if(strlen($cpfcopy) >= 9 ){// Se a string resultante for maior ou igual a 9(evita que os usuários tenham acesso a qualquer CPF busncando por algum número aleatório)
       $sql = "SELECT id, nome, cpf FROM participantes WHERE cpf LIKE '%".$cpfcopy."%'";
       $query = mysql_query($sql); 
       $count = mysql_num_rows($query);
       $row = mysql_fetch_array($query); 
    }else{
      $count = 0;
    }  
   
    //$sql = "SELECT id, nome, cpf, ativo FROM participantes WHERE (cpf = '".$cpfcopy."')";    

    // Teste para verificar se a query encontrou alguma tupla
    if($count == 0){//Se não há nenhuma tupla no resultado

      $output = 0; //A saída é 0, falsa
    }else {//Senão    
      $output = 1; //A saída é 1, positiva    
    }       
                  
?>

<html>
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css" rel="stylesheet" type="text/css">

    <script>

    //<!-- onkeypress="mascara(this, '###.###.###-##')" -->
    function mascara(t, mask){
      var i = t.value.length;
      var saida = mask.substring(1,0);
      var texto = mask.substring(i)
      if (texto.substring(0,1) != saida){
      t.value += texto.substring(0,1);
      }
     } 
    </script>

  </head><body>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <a><img src="img/FAENG_logo_evento_menor.png" width="624" height="436" class="center-block img-responsive"></a>
          </div>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1 class="text-center text-success">Declaração de participação</h1>
          </div>
        </div>
        <div class="row">
          <div class="col-md-offset-3 col-md-6">

            <form action="DeclaracaoParticipacao.php" method="POST" role="form">
              <div class="form-group">
                <div class="input-group">
                  <input type="text" name = "cpf" id = "txCpf" class="form-control" placeholder="Digite seu CPF: apenas números"  maxlength="12">
                  <span class="input-group-btn">
                    <input class="btn btn-success" type="submit" value = "Entrar">Pesquisar/>
                  </span>
                </div>
              </div>
            </form> 

            <!-- Escript para resultado da busca do CPF do paticipante -->
           <?php
              //Se a saída for falsa, ou seja, nenhum cpf encontrado
              if($output == 0){ 
                //Mensagem de alerta
                $alert = '<div class="alert alert-danger"role="alert" align="center" >
                Oops, CPF inválido. Tente novamente com o seu RGA
                <br>Algum problema na busca ou com o documento? Entre em contato com iisemanafaeng@gmail.com </div>';
                echo $alert;               
              }else{ //Se algum CPF for encontrado
                echo '<div id = "resultado" align="center"><h2 class="text-center text-info">';               
                echo $row['nome']; //Exibe o nome do participante encontrado via CPF
                echo '</h2></div>';
              
                echo '<p>';
                echo '<div align="center">';

                echo '<a href="DownloadDeclaracao.php?arquivo='.$cpf.'" align="center" class="btn btn-primary btn-lg enabled">Baixar declaração</a>';
               
                echo '</div>';  
                echo '</p>';                
              }
                
           ?>       
              
                                              
         </div>
        </div>
      </div>
    </div>
    <footer class="section section-primary text-left">
      <div class="container">
        <div class="row">
          <div class="col-sm-6">

            <h1>FAENG</h1>
            <p><strong>Faculdades de Engenharias,
                Arquitetura e Urbanismo e Geografia - Universidade Federal do Mato Grosso do Sul</strong></p>

              <br>(67) 3345-7450
              <br>Cidade Universitária. CEP 79070-900. Campo Grande - MS
              <br>Caixa Postal 549              

          </div>
          <div class="col-sm-6">
            <p class="text-info text-right">
              <br>
              <br>
            </p>
            <div class="row">
              <div class="col-md-12 hidden-lg hidden-md hidden-sm text-left">
                <a href="#"><i class="fa fa-3x fa-fw fa-instagraglyphicon glyphicon-phonem text-inverse"></i></a>       <a href="#"><i class="fa fa-3x fa-fw fa-facebook text-inverse"></i></a>                
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 hidden-xs text-right">
                <a href="https://www.instagram.com/semanafaeng/"><i class="fa fa-3x fa-fw fa-instagram text-inverse"></i></a>
                <a href="https://www.facebook.com/II-Semana-da-FAENG-289587434710494/?fref=ts"><i class="fa fa-3x fa-fw fa-facebook text-inverse"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>
  

</body></html>

<?php $cpf = ''; mysql_close($id_connection); ?>
