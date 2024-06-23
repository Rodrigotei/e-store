let idUser = getCookie('idUser');

if(idUser == null){
    let id = gerarDigitosAleatorios();
    let data = new Date();
    data.setTime(data.getTime() + (60 * 1000 * 60 * 24));
    let dateExpire =    data.toUTCString();
    document.cookie = 'idUser ='+id+'; expires= '+dateExpire;
    localStorage.setItem('idUser',id);
}
function gerarDigitosAleatorios() {
    let code = '';
    const alfabetoNumeros = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    for(let i = 0; i < 5; i++){ 
        let digito = Math.floor(Math.random() * alfabetoNumeros.length);
        code += alfabetoNumeros[digito];
    }
    return code;
}
function getCookie(cookieName) {
    let cookies = document.cookie; 
    let cookieArray = cookies.split(';');
    for (let i = 0; i < cookieArray.length; i++) {
        let cookie = cookieArray[i].trim();
        // Verifica se o cookie começa com o nome desejado
        if (cookie.startsWith(cookieName + '=')) {
            // Retorna o valor do cookie, removendo o nome e o sinal de igual
            return cookie.substring(cookieName.length + 1);
        }
    }
    return null;
}
