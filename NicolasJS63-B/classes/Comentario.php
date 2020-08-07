<?php

class Comentario{
    private $id;
    private $comentario;
    private $data;
    private $noticia;
    private $usuario;

    public function setId($id){
        $this->id=$id;
    }
    
    public function getId(){
        return $this->id;
    }

    public function setComentario($comentario){
        $this->comentario=$comentario;
    }
    
    public function getComentario(){
        return $this->comentario;
    }

    public function setDatad($data){
        $this->data=$data;
    }
    
    public function getData(){
        return $this->data;
    }

    public function setNoticia($noticia){
        $this->noticia=$noticia;
    }
    
    public function getNoticia(){
        return $this->noticia;
    }

    public function setUsuario($usuario){
        $this->usuario=$usuario;
    }
    
    public function getUsuario(){
        return $this->usuario;
    }

    public function salvar($id_noticia, $comentario, $id_usuario){
        $conexao = Conexao::getInstance();
        $sql = 'INSERT INTO comentario (id_comentario, comentario, noticia_id, usuario_id) VALUES(0,"'.$comentario.'","'.$id_noticia.'","'.$id_usuario.'")';
        if ($conexao->query($sql)){
            return true;
        }
        else {
            return false;
        }
    }

    public function listar($id_noticia = null){
        $conexao = Conexao::getInstance();
        $sql = 'SELECT comentario, (SELECT nome FROM usuario WHERE id_usuario = c.id_usuario) AS nome_usuario FROM comentario c';
        if ($id_noticia) {
            $sql .= 'WHERE id_noticia = '.$id_noticia;
        }
        $resultado = $conexao->query($sql);
        while ($item = $resultado->fetch(PDO::FETCH_OBJ)) {
            $comentarios[] = $item;
        }

        if (isset($comentarios)){
            return $comentarios;
        }
        else {
            return false;
        }
    }

}