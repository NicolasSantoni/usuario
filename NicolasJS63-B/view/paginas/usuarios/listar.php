<main>
    <?php
        if ($_SESSION['user']->admin==2){
          ?>
          <a href="adicionar.php">
            <svg width="3em" height="3em" viewBox="0 0 16 16" class="bi bi-person-plus-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm7.5-3a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
              <path fill-rule="evenodd" d="M13 7.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0v-2z"/>
            </svg>
          </a>
          <?php
          $teste = 1;
        }
    ?>
    <table class="table">
    <thead>
        <tr><td>#</td><td>Nome</td><td>Email</td><td>Profissão</td></tr>
    </thead>
    <?php
      $conexao = Conexao::getInstance();
      $resultado = $conexao->query('SELECT * FROM usuario');
      while ($usuarios = $resultado->fetch(PDO::FETCH_OBJ)) {
        if ($teste==1) {
          $deletar='
            <a href="'.HOME_URI.'usuario/deletar/'.$usuarios->id.'">
              <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/>
              </svg>
            </a>
          ';
        }
        if ($usuarios->admin == 0) {
          $prof = 'Aluno';
        }
        elseif ($usuarios->admin == 1) {
          $prof = 'Professor';
        }
        elseif ($usuarios->admin == 2) {
          $prof = 'Administrador';
        }
        if ($_SESSION['user']->id != $usuarios->id) {
          echo "
            <tr>
              <td>$usuarios->id</td>
              <td>$usuarios->nome</td>
              <td>$usuarios->email</td>
              <td>$prof</td>
              <td>$deletar</td>
            </tr>
          ";
        }
        else {
          echo "
            <tr>
              <td>$usuarios->id</td>
              <td>$usuarios->nome</td>
              <td>$usuarios->email</td>
              <td>$prof</td>
            </tr>
          ";
        }
      }

    ?>
    </table>
