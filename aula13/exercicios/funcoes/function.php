<?php
    function salvaPessoasTxt($pessoas) {
        $conteudo = "";

        foreach ($pessoas as $pessoa) {
            $conteudo .= "----------------------------------------\n";
            $conteudo .= "Nome: " . $pessoa->getNomeCompleto() . "\n";
            $conteudo .= "Idade: " . $pessoa->getIdade() . "\n";
            $conteudo .= "Tipo: " . $pessoa->getDescricaoTipo() . "\n";
            $conteudo .= "CPF/CNPJ: " . $pessoa->getCpfCnpj() . "\n";

            // Endereço
            if ($pessoa->getEndereco() != null) {
                $end = $pessoa->getEndereco();
                $conteudo .= "Endereço: " . $end->getLogradouro() . ", " . $end->getBairro() . "\n";
                $conteudo .= $end->getCidade() . " - " . $end->getEstado() . " | CEP: " . $end->getCep() . "\n";
            }

            // Contatos
            if (!empty($pessoa->getContatos())) {
                $conteudo .= "Contatos: \n";
                foreach ($pessoa->getContatos() as $c) {
                    $conteudo .= " - " . $c->getDescricaoTipo() . ": " . $c->getValor() . "\n";
                }
            }

            $conteudo .= "\n";
        }

        file_put_contents("pessoas.txt", $conteudo);

        echo "Arquivo salvo com sucesso: " . realpath("pessoas.txt");
    }

    function salvaPessoasJson($pessoas) {
        $array = [];

        foreach ($pessoas as $p) {
            $array[] = $p->toArray();
        }

        file_put_contents("pessoas.json", json_encode($array, JSON_PRETTY_PRINT));

        echo "Arquivo salvo com sucesso: " . realpath("pessoas.json");
    }
    
?>