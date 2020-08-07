<?php

class Noticia{
    private $id;
    private $titulo;
    private $descricao;
    private $comentarios;
    private $data;
    private $usuario;

    public function setId($id){
        $this->id=$id;
    }
    
    public function getId(){
        return $this->id;
    }

    public function setTitulo($titulo){
        $this->titulo=$titulo;
    }
    
    public function getTitulo(){
        return $this->titulo;
    }

    public function setDescricao($descricao){
        $this->descricao=$descricao;
    }
    
    public function getDescricao(){
        return $this->descricao;
    }

    public function setComentarios($comentarios){
        $this->comentarios=$comentarios;
    }
    
    public function getComentarios(){
        return $this->comentarios;
    }
    public function setData($data){
        $this->data=$data;
    }
    
        public function getData(){
        return $this->data;
    }
    public function setUsuario($usuario){
        $this->usuario=$usuario;
    }
    
    public function getUsuario(){
        return $this->usuario;
    }

    public function index(){
        $this->listar();
    }

    public function listar(){
        $conexao=Conexao::getInstance();
        $sql="SELECT id, titulo, descricao, DATE_FORMAT(data, '%d/%m/%Y') AS data,
        (SELECT nome FROM usuario WHERE id=noticia.usuario_id)AS nome_usuario 
        FROM noticia
        ORDER BY id DESC LIMIT 5";
        
        $resultado=$conexao->query($sql);
        $noticias=null;

        while($noticia=$resultado->fetch(PDO::FETCH_OBJ)){
            $noticias[]=$noticia;
        }
        
        include HOME_DIR."view/paginas/noticias/noticias.php";
    }

    public function ver($id){
        $conexao=Conexao::getInstance();
        $sql="SELECT id, titulo, descricao, DATE_FORMAT(data, '%d/%m/%Y') AS data,
        (SELECT nome FROM usuario WHERE id=noticia.usuario_id)AS nome_usuario 
        FROM noticia
        WHERE id=".$id;

        $resultado=$conexao->query($sql);
        $noticia=$resultado->fetch(PDO::FETCH_OBJ);

        include "Comentario.php";
        $comentario = new Comentario();
        $noticia->comentarios = $comentario->listar($noticia->id);

        include HOME_DIR."view/paginas/noticias/noticia.php";
    }
    
    public function comentar(){
        include "Comentario.php";
        $comentario = new Comentario();
        if ($comentario->salvar($_POST['id_noticia'], $_POST['comentario'], $_POST['id_usuario'])){
            $msg['msg'] = "Comentário adicionado!";
            $msg['class'] = "success";
            $_SESSION['msg'] = $msg;
        }
        else {
            $msg['msg'] = "Falha ao adicionar comentário!";
            $msg['class'] = "danger";
            $_SESSION['msg'] = $msg;
        }
        header("location:".HOME_URI."noticia/ver/".$_POST['id_noticia']);
    }

}


?>