<?php 
declare(strict_types=1);

class Lotofacil {

    private $arquivo;
    
    function __construct(string $arquivo) {
        $this->arquivo = $arquivo;
    }

    public function carregarConteudo() : array {
        $conteudo = @fopen($this->arquivo, 'r');
        $listaLotofacil = array();

        while(($linha = fgetss($conteudo,4096)) !== false) {
            $listaLotofacil[] = $linha;
        }
        fclose($conteudo);

        return $listaLotofacil;
        
    }    

    public function validaConteudo(array $lista) : array {

        $jogo = array();
        foreach ($lista as $key => $value) {
            
            $tamanho_linha = strlen(trim($value));
            $valor = trim($value);

            if(($tamanho_linha == 2) || ($tamanho_linha == 10)) {
                
                // verificando se é um numero
                if(($tamanho_linha == 2) && (is_numeric($valor))) {
                    $jogo[] = $valor;
                } else
                
                // verificando se é uma data
                if($tamanho_linha == 10) {
                    $ocorrencia = strpos($valor,'/');
                    if($ocorrencia) {
                        $jogo[] = $valor;
                    }                    
                }
            }            
        }

        return $jogo;
    }


    public function matriz(array $lista) : array {
        
        $jogo = array();
        $contador   = 1;
        $registro   = 0;
        $item       = 0;
        $posicao    = 0;
        foreach ($lista as $key => $value) {
            
            if(1 == 1) { // Para limitar a quantidade de jogos

                if(strlen($value) == 10) {
                    $item = 0;
                    $jogo[$registro] = array($item=>$value);
                    $posicao = $registro;

                    $registro++;

                } else {
                    $item++;
                    $jogo[$posicao] += array($item => $value);
                }
            }

            $contador++;

        }
        
        return $jogo;
    }

    public function jogos_vencedores(array $matriz, array $meu_jogo, int $pontos=15) : array {

        $qtde_jogos = 1;
        $acertos = array();
        
        $contador = 0;

        // Conjunto de jogos...
        foreach($matriz as $nova_key => $nova_matriz) {
        
            if(1 == 1) {// Para limitar a quantidade de jogos
        
                $qtde_acertos = 0;
        
                // Jogos Individuais...
                foreach ($nova_matriz as $key => $value) {
                    
                    if($key == 0) {
                        $data_jogada = $value;
                    } else {
        
                        //Meus jogos...
                        foreach ($meu_jogo as $k => $v) {
                            
                            if((int)$value == (int)$v) {
                                $qtde_acertos++;
                            }
                        }
                    }
                }
                if($qtde_acertos >= $pontos) {
                    $acertos += array($data_jogada=>$qtde_acertos);
                }
                
                $contador++;
            }
        } 
        
        return $acertos;

    }

    public function numerosExcluidos(array $meu_jogo) : array {

        $numeros_excluidos = [];

        for($x=1;$x<=25;$x++) {
            
            if(!in_array($x, $meu_jogo)) {
                array_push($numeros_excluidos, $x);
            }
        }
        return $numeros_excluidos;
    }

    public function superCombinacao(array $matriz, array $meu_jogo):void {
        
        $lista      = $this->numerosExcluidos($meu_jogo);
        
        $nova_lista     = array();
        $sequencia_boa  = array();
        
        $contador       = 0;
        $qtde_apostas   = 0;
        $proximo        = 0;
        
        foreach ($meu_jogo as $key => $value) {
            echo str_pad((string)$value, 2, " ", STR_PAD_LEFT)." ";
        }
        echo " -> Série Original\n\n\n";

        foreach ($lista as $k => $v) {
            
            foreach ($meu_jogo as $chave => $valor) {
                if($contador == 0) {
                    $nova_lista[$contador] = $v;            
                } else {
                    $nova_lista[$contador] = $valor;
                }
                
                $contador++;
               
            }
        
            sort($nova_lista);
        
            foreach ($nova_lista as $key => $value) {
                echo str_pad((string)$value, 2, " ", STR_PAD_LEFT)." ";
            }
            echo "\n";

            $jogos_vencedores = $this->jogos_vencedores($matriz, $nova_lista, 14);
        
            foreach ($jogos_vencedores as $key => $value) {
                echo $key ." - Pontos: " . $value . "\n";
            }
        
            $contador = 0;
            $proximo++;
        }        
    }

}