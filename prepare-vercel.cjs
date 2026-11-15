const fs=require('node:fs');
fs.mkdirSync('public',{recursive:true});
const pages=['pg_inicial.html','camietas.html','shorts.html','chuteiras.html','carrinho.html'];
for(const page of pages){
 let html=fs.readFileSync(page,'utf8').replaceAll('Pg-Inicial.html','index.html').replaceAll('Pg-Inicio.css','pg_inicial.css').replaceAll('camisetas.html','camietas.html').replaceAll('calcao.html','shorts.html');
 fs.writeFileSync('public/'+(page==='pg_inicial.html'?'index.html':page),html);
}
for(const name of ['pg_inicial.css','carrinho.js']) fs.copyFileSync(name,'public/'+name);
