<?php

namespace Api;

use Api\Methods\Carrinho;
use Api\Methods\Categorias;
use Api\Methods\User;

class ApplicationPOST
{
    public function initApp($req = [], $files = []) {
        //==================================================================================================
                                            // CREATE CLIENTE
        //==================================================================================================

        if (isset($req['createUser']) && $req['createUser'] && isset($req['idUser'])) {
            $app = new User;
            $qtdClient = $app->selectClient($req['idUser']);
            if(count($qtdClient) == 0){
                $createUser = $app->createClient($req['idUser']);
                if($createUser){
                    return true;
                }
            }
        }

        //==================================================================================================

        //==================================================================================================
                                            // REQUESTS APP
        //==================================================================================================

        if (isset($req['addCart']) && $req['addCart'] && isset($req['idProduct']) && isset($req['idUser'])) {
            $qtdProduct = 1;
            $app = new Carrinho;
            $date = date('Y-m-d');
            $verificarCarrinho = $app->selecionarProdutoInd($req['idProduct'], $req['idUser']);
            if(count($verificarCarrinho) > 0){
                $updateQtd = $app->updateQtdProduct($req['idProduct'], $req['idUser']);
                return $updateQtd;
            }else{
                $res = $app->addCart($req['idProduct'], $qtdProduct, $req['idUser'], $date);
                return $res; 
            }
        }

        if (isset($req['decreaseQtdProduct']) && $req['decreaseQtdProduct'] && isset($req['idProduto']) && isset($req['idUser'])) {
            $app = new Carrinho;
            
            $decreaseQtd = $app->decreaseQtd($req['idProduto'], $req['idUser']);
            return true;
        }
        if (isset($req['increaseQtdProduct']) && $req['increaseQtdProduct'] && isset($req['idProduto']) && isset($req['idUser'])) {
            $app = new Carrinho;
            
            $decreaseQtd = $app->updateQtdProduct($req['idProduto'], $req['idUser']);
            return true;
        }
        if (isset($req['deleteProduct']) && $req['deleteProduct'] && isset($req['idProduto']) && isset($req['idUser'])) {
            $app = new Carrinho;
            
            $deleteProduct = $app->deleteProduct($req['idProduto'], $req['idUser']);
            return true;
        }
        
        //=================================================================================================================

        //=================================================================================================================
                                                    // REQUESTS DASHBOARD
        //=================================================================================================================
        if(isset($req['authenticate']) && $req['authenticate'] && isset($req['user']) && isset($req['pass'])){
            $app = new User;
            $login = $app->selectUserLogin($req['user'], $req['pass']);
            if($login){
                return true;
            }
            return false;
        }

        if(isset($req['nameCategory']) && isset($files['imgCategory'])){
            $nameCategory = $req['nameCategory'];
           
            $extensaoImg = pathinfo($files['imgCategory']['name'], PATHINFO_EXTENSION);
            $extensoes_permitidas = array("jpg", "jpeg", "png", "gif", "bmp", "webp", "tiff", "svg");
            if(in_array($extensaoImg, $extensoes_permitidas)){
                $localImg = $files['imgCategory']['tmp_name'];
                $img = explode('.',$files['imgCategory']['name']);
                $nameImgCategory = $img[0].rand(0,99).'.'.end($img);

                $app = new Categorias;
                $insertCategory = $app->insertCategory($nameCategory, $nameImgCategory);
                if($insertCategory){
                    if(move_uploaded_file($localImg, 'images/img/categories/'.$nameImgCategory)){
                        return 'Categoria adicionada com sucesso!';
                    }else{
                        return 'A categoria foi adicionada, mas houve um problema com a imagem!';
                    }
                }
                return 'Erro ao adicionar!';
            }
        }

        if(isset($req['deleteCat']) && $req['deleteCat'] && isset($req['idDelete'])){
            $app = new Categorias;
            $deleteCategory = $app->deleteCat($req['idDelete']);
            if($deleteCategory){
                return 'A categoria foi excluída com sucesso!';
            }
            return 'Erro ao excluir';
        }
        
        
        //=================================================================================================================
        return 'INVALID REQUEST';
    }
}