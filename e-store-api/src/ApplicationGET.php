<?php

namespace Api;

use Api\Methods\Adicionais;
use Api\Methods\Categorias;
use Api\Methods\Produtos;
use Api\Methods\Carrinho;

class ApplicationGET
{
    public function initApp($page, $parameter = null){
        switch ($page){
            case 'categorias':
                $app = new Categorias;
                if($parameter != null){
                    //SELECIONA TODOS OS PRODUTOS DE UMA CATEGORIA ESPECÍFICA
                    $response = $app->selectProdutosCat($parameter);
                    return $response; 
                }else{
                    //SELECIONA TODAS AS CATEGORIAS
                    $response = $app->selectCategorias();
                    return $response;
                }
                break;
            case 'produtos':
                $app = new Produtos;
                if($parameter != null){
                    //SELECIONA UM PRODUTO EM ESPECÍFICO
                    $res = $app->selectProdutc($parameter);
                    return $res;
                }else{  
                    //SELECIONA TODOS OS PRODUTOS
                    $res = $app->selectAllProducts();
                    return $res;
                }
                break;
            case 'fotosProduto':
                if($parameter != null){
                    $app = new Produtos;
                    //SELECIONA FOTOS ADICIONAIS DO PRODUTO
                    $res = $app->selectImgProduct($parameter);
                    return $res;
                }
                break;
            case 'ultimosProdutos':
                $app = new Produtos;
                //SELECIONA OS ÚLTIMOS PRODUTO ID DESC
                $res = $app->selectLastProdutc();
                return $res;
                break;
            case 'carrinho':
                if($parameter != null){
                    $app = new Carrinho;
                    $res = $app->obterCarrinho($parameter);
                    return $res;
                }   
                break;
            case 'quantidadeCarrinho':
                if($parameter != null){
                    $app = new Carrinho;
                    $res = $app->obterQuantidadeCarrinho($parameter);
                    return $res; 
                }
                break;
            case 'adicionais':
                $app = new Adicionais;
                if($parameter != null){
                    $res = $app->selectAdicionais($parameter);
                    return $res;
                }else{  
                    $res = $app->selectAllAdicionais();
                    return $res;
                }
                break;
            default:
                echo 'ENDPOINT NOT FOUND';
                exit;
        }
    }
}