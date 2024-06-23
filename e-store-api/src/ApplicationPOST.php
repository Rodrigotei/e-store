<?php

namespace Api;

use Api\Methods\Carrinho;

class ApplicationPOST
{
    public function initApp($req = []) {
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
        return 'INVALID REQUEST';
    }
}