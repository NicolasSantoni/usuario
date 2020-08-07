<?php
class Usuario{
    private $id;
    private $nome;
    private $email;
    private $senha;

    public function setId($id){
        $this->id=$id;
    }
    public function getId(){
        return $this->id;
    }
    public function setNome($nome){
        $this->nome=$nome;
    }

    public function getNome(){
        return $this->nome;
    }

    public function setEmail($email){
        $this->email=$email;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setSenha($senha){
        $this->senha=$senha;
    }

    public function getSenha(){
        return $this->senha;
    }


    public function index(){
        if (!isset($_SESSION['user'])){
            $this->login();
        }
        else {
            $this->listar();
        }

    }

    public function listar(){
        include HOME_DIR."view/paginas/usuarios/listar.php";
    }

    public function criar(){
        include HOME_DIR."view/paginas/usuarios/form_usuario.php";
    }

    public function salvar(){
        $conexao = Conexao::getInstance();
        $sql = 'INSERT INTO usuario (nome, email, senha, primvez, admin) VALUES ("'.$_POST['nome'].'","'.$_POST['email'].'","'.md5('info63b').'",'.'1'.','.$_POST['tipo'].')';
        if ($conexao->query($sql)){
          echo "<script>alert('Cadastro feito com sucesso! Sua senha é info63b, troque-a ao logar.');</script>";
          include HOME_DIR."view/paginas/usuarios/listar.php";
        }
        else{
          echo "<script>alert('Ocorreu um erro!');</script>";
          include HOME_DIR."view/paginas/usuarios/form_usuario.php";
        }
    }

    public function exibir($id){
        echo "O id do usuario é".$id;
    }

    public function login(){
        echo "<script>alert('Email ou senha incorretos!');</script>";
        include HOME_DIR."view/paginas/usuarios/entrar.php";
    }

    public function senha(){
        include HOME_DIR."view/paginas/usuarios/senha_padrao.php";
    }

    public function deletar($id){
        $conexao = Conexao::getInstance();
        $sql = 'DELETE FROM usuario WHERE id='.$id;
        if ($conexao->query($sql)){
          echo "<script>alert('Usuário deletado!');</script>";
        }
        else{
          echo "<script>alert('Ocorreu um erro!');</script>";
        }
        include HOME_DIR."view/paginas/usuarios/listar.php";
    }

    public function trocar_senha(){
      $_SESSION['user']->primvez = 0;
        $conexao = Conexao::getInstance();
        $sql = 'UPDATE usuario SET senha = "'.md5($_POST['senha']).'" WHERE id = '.$_SESSION['user']->id;
        if ($conexao->query($sql)){
            if ($_SESSION['user']->primvez){
                $sql = 'UPDATE usuario SET primvez = '.'0'.' WHERE id = '.$_SESSION['user']->id;
                $conexao->query($sql);
                $_SESSION['user']->primvez = 0;
            }
            echo "<script>alert('Senha alterada com sucesso!');</script>";
            header('Location:'.HOME_URI);
        }
        else{
          echo "<script>alert('Ocorreu um erro!');</script>";
          include HOME_DIR."view/paginas/usuarios/trocarsenha.php";
        }
    }

    public function autenticar(){
        $conexao = Conexao::getInstance();
        $email = $_POST['email'];
        $sql = 'SELECT senha FROM usuario WHERE email="'.$email.'"';
        $resultado = $conexao->query($sql);
        $senha = $resultado->fetch(PDO::FETCH_OBJ);
        if (!$senha) {
            $msg['msg'] = "Usuário ou senha invalidos!";
            $msg['class'] = "danger";
            $_SESSION['msg'] = $msg;
            $this->login();
        }
        else {
            if (md5($_POST['senha']) === $senha->senha){
                $sql = 'SELECT * FROM usuario WHERE email="'.$email.'"';
                $resultado = $conexao->query($sql);
                $_SESSION['user'] = $resultado->fetch(PDO::FETCH_OBJ);
                header('Location:'.HOME_URI);
            }
            else{
                $this->login();
            }
        }
    }

    public function logout(){
        session_destroy();
        header('Location:'.HOME_URI);
    }
}
