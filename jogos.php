<?php
/*+-------------------------------------+
| Desenvolvedor: Fabio Eduardo do Vale  |
| Data: 24/06/2019                      |
| Versão: 0.0.2                         |
+---------------------------------------+*/

include('lotofacil.php');

$lfacil = new lotofacil('d_lotfac.htm');

$conteudo       = $lfacil->carregarConteudo();
$validaConteudo = $lfacil->validaConteudo($conteudo);
$matriz         = $lfacil->matriz($validaConteudo);

$meu_jogo   = array(1,4,5,7,10,13,14,16,17,18,19,20,21,22,25);

print_r($lfacil->numerosExCluidos($meu_jogo));

$lfacil->superCombinacao($matriz, $meu_jogo);

