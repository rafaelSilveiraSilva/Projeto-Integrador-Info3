<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.8/css/bootstrap.min.css" integrity="sha512-2bBQCjcnw658Lho4nlXJcc6WkV/UxpE/sAokbXPxQNGqmNdQrWqtw26Ns9kFF/yG792pKR1Sx8/Y1Lf1XN4GKA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.8/js/bootstrap.min.js" integrity="sha512-nKXmKvJyiGQy343jatQlzDprflyB5c+tKCzGP3Uq67v+lmzfnZUi/ZT+fc6ITZfSC5HhaBKUIvr/nTLCV+7F+Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>

    <!-- Criando uma div com a classe container fluid para responsividade, com o p-3 para aplicar
    um padding nas bordas -->
    <div class="container-fluid p-3">

        <!-- Uma div com a classe row para criar uma linha com texto centralizado e com espaçamento igual
         a 3 pra parte inferior, originando uma espécie de espaçamento abaixo com o mb-3 -->
        <div class="row text-center mb-3">

        <!-- Breve texto de boas vindas, sujeito a exclusão :O -->
            <h1>Bem vindo ao site!!!</h1>


        </div>

        <!-- Uma div com a classe row para criar uma linha com os conteúdos centralizados -->
        <div class="row justify-content-center">
            <!-- imagem qualquer que coloquei só pra exemplificar -->
            <img src="https://i.ytimg.com/vi/mcb-4Y9msao/sddefault.jpg" class="img-fluid w-50">
        </div>

        <!-- Uma div da classe row com espaçamento de padding igual a 5 devido ao p-5 -->
        <div class="row p-5">
            <!-- Informações só mesmo -->
            <h1>O que é nosso site?</h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Incidunt iusto esse cupiditate voluptatum officiis est quas eius dolore dolores, pariatur facilis minus voluptatibus maiores repellendus. Illum, distinctio error unde reiciendis harum quaerat. Autem accusantium eum perferendis sed voluptate. Iste sapiente eligendi dolorum, quisquam reprehenderit optio quaerat odit illum mollitia, dolorem nemo iure, architecto ipsum beatae minus cumque impedit nam velit ratione repellat ipsam sed qui. Ut minima maxime neque cum, nisi, aliquid odit illum inventore fuga et, eligendi incidunt sit.</p>
        </div>
        <!-- Uma div da classe row com espaçamento de padding igual a 5 devido ao p-5 -->
        <div class="row p-5">
            <!-- Informações só mesmo -->
            <h1>Teste já!</h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Incidunt iusto esse cupiditate voluptatum officiis est quas eius dolore dolores, pariatur facilis minus voluptatibus maiores repellendus. Illum, distinctio error unde reiciendis harum quaerat. Autem accusantium eum perferendis sed voluptate. Iste sapiente eligendi dolorum, quisquam reprehenderit optio quaerat odit illum mollitia, dolorem nemo iure, architecto ipsum beatae minus cumque impedit nam velit ratione repellat ipsam sed qui. Ut minima maxime neque cum, nisi, aliquid odit illum inventore fuga et, eligendi incidunt sit.</p>
        </div>

        <!-- Uma div da classe row com os textos dentro dela centralizados
            (centraliza os "botões" também por conta da tag <a> também ser afetada pelo "text-center") -->
        <div class="row text-center">
            <!-- Na mesma linha tem duas colunas, uma com o botão que direciona para a página de cadastro
             e outra para a de login -->
            <div class="col">
                <a href="cadastro.php" class="btn btn-primary">Ir para o cadastro</a>
            </div>
            <div class="col">
                <a href="login.php" class="btn btn-primary">Ir para o login</a>
            </div>
        </div>
    </div>
</body>



</html>