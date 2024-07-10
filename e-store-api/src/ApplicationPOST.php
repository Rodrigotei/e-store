<?php

namespace Api;

use Api\Methods\Carrinho;
use Api\Methods\Categorias;
use Api\Methods\Produtos;
use Api\Methods\User;

class ApplicationPOST
{
    public function initApp($req = [], $files = []) {
//===========================================================================================================================================================
                                                       // CREATE CLIENTE
//===========================================================================================================================================================

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

//===========================================================================================================================================================

//===========================================================================================================================================================
                                                       // REQUESTS APP
//===========================================================================================================================================================

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
        
//===========================================================================================================================================================

//===========================================================================================================================================================
                                                    // REQUESTS DASHBOARD
//===========================================================================================================================================================
        if(isset($req['authenticate']) && $req['authenticate'] && isset($req['user']) && isset($req['pass'])){
            $app = new User;
            $login = $app->selectUserLogin($req['user'], $req['pass']);
            if($login){
                return true;
            }
            return false;
        }
//=========================================================    PAGE CATEGORIES    ================================================================== 
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
        
        if(isset($req['editCategory']) && $req['editCategory']  && isset($req['nameCategory'])&& isset($req['idCategory'])){
            $app = new Categorias;
            $editCategory = $app->editCategory($req['nameCategory'], $req['idCategory']);
            if($editCategory){
                return 'Categoria Editada com sucesso!';
            }
            return 'Erro ao editar'; 
        }
        if(isset($req['nameCategory']) &&isset($req['idCategory']) && isset($files['newImgCategory'])){
            $nameCategory = $req['nameCategory'];
            
            $extensaoImg = pathinfo($files['newImgCategory']['name'], PATHINFO_EXTENSION);
            $extensoes_permitidas = array("jpg", "jpeg", "png", "gif", "bmp", "webp", "tiff", "svg");
            if(in_array($extensaoImg, $extensoes_permitidas)){
                $localImg = $files['newImgCategory']['tmp_name'];
                $img = explode('.',$files['newImgCategory']['name']);
                $nameImgCategory = $img[0].rand(0,99).'.'.end($img);

                $app = new Categorias;
                $insertCategory = $app->updateCategoryImage($nameCategory, $nameImgCategory, $req['idCategory']);
                if($insertCategory){
                    if(move_uploaded_file($localImg, 'images/img/categories/'.$nameImgCategory)){
                        return 'Categoria Editada com sucesso!';
                    }else{
                        return 'A categoria foi editada, mas houve um problema com a imagem!';
                    }
                }
                return 'Erro ao editar!';
            }
        }
//=========================================================    PAGE PRODUCTS    ================================================================== 
        if(isset($req['nameProduct']) && isset($files['imgProduct']) && isset($req['descProduct']) && isset($req['priceProduct']) && isset($req['idCategory'])){
            $nameProduct = $req['nameProduct'];
            $descProduct = $req['descProduct'];
            $priceProduct = $req['priceProduct'];
            $idCategory = $req['idCategory'];
           
            $extensaoImg = pathinfo($files['imgProduct']['name'], PATHINFO_EXTENSION);
            $extensoes_permitidas = array("jpg", "jpeg", "png", "gif", "bmp", "webp", "tiff", "svg");
            if(in_array($extensaoImg, $extensoes_permitidas)){
                $localImg = $files['imgProduct']['tmp_name'];
                $img = explode('.',$files['imgProduct']['name']);
                $nameImgProduct = $img[0].rand(0,99).'.'.end($img);

                $app = new Produtos;
                $insertProduct = $app->insertProduct($nameProduct, $descProduct, $priceProduct, $nameImgProduct, $idCategory);
                if($insertProduct){
                    if(move_uploaded_file($localImg, 'images/img/produtos/'.$nameImgProduct)){
                        return 'Produto adicionado com sucesso!';
                    }else{
                        return 'O Produto foi adicionado, mas houve um problema com a imagem!';
                    }
                }
                return 'Erro ao adicionar!';
            }else{
                return 'O arquivo enviado não é uma imagem!';
            }
        }
        if(isset($req['deleteProd']) && $req['deleteProd'] && isset($req['idDelete'])){
            $app = new Produtos;
            $deleteProduct = $app->deleteProd($req['idDelete']);
            if($deleteProduct){
                return 'O Produto foi excluído com sucesso!';
            }
            return 'Erro ao excluir';
        }

        if(isset($req['editProduct']) && $req['editProduct']  && isset($req['nameProduct']) && isset($req['descProduct']) && isset($req['priceProduct']) && isset($req['idProduct'])){
            $app = new Produtos;
            $editProduc = $app->editProduct($req['nameProduct'], $req['descProduct'], $req['priceProduct'], $req['idProduct']);
            if($editProduc){
                return 'Produto Editado com sucesso!';
            }
            return 'Erro ao editar'; 
        }
        
        if(isset($req['nameProduct']) && isset($req['priceProduct']) && isset($req['descProduct']) && isset($req['idProduct']) && isset($files['imgProduct'])){
            $nameProduct = $req['nameProduct'];
            
            $extensaoImg = pathinfo($files['imgProduct']['name'], PATHINFO_EXTENSION);
            $extensoes_permitidas = array("jpg", "jpeg", "png", "gif", "bmp", "webp", "tiff", "svg");
            if(in_array($extensaoImg, $extensoes_permitidas)){
                $localImg = $files['imgProduct']['tmp_name'];
                $img = explode('.',$files['imgProduct']['name']);
                $nameImgProduct = $img[0].rand(0,99).'.'.end($img);

                $app = new Produtos;
                $editProduct = $app->editProductImg($nameProduct,$req['descProduct'], $req['priceProduct'], $nameImgProduct, $req['idProduct']);
                if($editProduct){
                    if(move_uploaded_file($localImg, 'images/img/produtos/'.$nameImgProduct)){
                        return 'Produto Editado com sucesso!';
                    }else{
                        return 'O Produto foi editado, mas houve um problema com a imagem!';
                    }
                }
                return 'Erro ao editar!';
            }
        }
//=========================================================    PAGE IMG PRODUCTS    ================================================================== 
        if (isset($req['productId']) && isset($files['images'])) {
            $nome = '';
            for ($i = 0; $i < count($files['images']['name']); $i++) {
                
                // Verifica se houve erro no upload do arquivo
                if ($files['images']['error'][$i] !== UPLOAD_ERR_OK) {
                    return 'Erro no upload da imagem: ' . $files['images']['name'][$i];
                }
                
                $extensaoImg = pathinfo($files['images']['name'][$i], PATHINFO_EXTENSION);
                $extensoes_permitidas = array("jpg", "jpeg", "png", "gif", "bmp", "webp", "tiff", "svg");
                
                if (in_array($extensaoImg, $extensoes_permitidas)) {
                    $img = explode('.', $files['images']['name'][$i]);
                    $localName = $files['images']['tmp_name'][$i];
                    $nameImg = $img[0] . rand(0, 99) . '.' . end($img);  
                    
                    $app = new Produtos;
                    $editProduct = $app->insertImgProducts($nameImg, intval($req['productId']));
                    
                    if ($editProduct) {
                        if (move_uploaded_file($localName, 'images/img/produtos/' . $nameImg)) {
                            // Arquivo movido com sucesso
                        } else {
                            return 'Erro ao mover o arquivo: ' . $nameImg;
                        }
                    }
                } else {
                    return 'Extensão de imagem não permitida: ' . $files['images']['name'][$i];
                }
            }
            return 'Imagens do Produto adicionadas com sucesso!';
        }

//=========================================================================================================================================
        return 'INVALID REQUEST';
    }
}