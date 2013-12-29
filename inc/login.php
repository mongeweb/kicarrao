<div class="clientesbloco">
    <p class="clientestitulo"><img src="<?=ssl().PROJECT_URL;?>/img/iconeclientes.png" alt="Clientes" />Clientes</p>
    <form name="loginCliente" id="loginCliente" method="post" action="" enctype="multipart/form-data">
        <div class="blocodeslogado">
            <label for="usuario" class="loginlb">Usuário</label>
            <input type="text" name="usuario" id="usuario" title="Usuário" />
            <br clear="all" />
            <label for="senha" class="loginlb">Senha</label>
            <input type="text" name="senha" id="senha" title="Senha" />
            <input type="submit" name="enviarLogin" id="enviarLogin" title="Enviar" value="OK" />
            <div class="lembrarsenha">
                <input type="checkbox" name="lembrar" id="lembrar" title="Lembrar Senha" />
                <label for="lembrar">Lembrar senha</label>
            </div>
            <div class="esquecisenha">
                <a href="#"><img src="<?=ssl().PROJECT_URL;?>/img/setaclique.png" alt="Esqueci a senha" />Esqueci a senha</a>
            </div>
        </div>
        <div class="blocologado">
            <p class="bemvindo">Bem vindo, <span>usuário</span>.</p>
            <input type="submit" name="sairCliente" id="sairCliente" value="Sair" />
        </div>
    </form>
</div>