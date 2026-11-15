const fs=require('node:fs');
const path=require('node:path');
const zlib=require('node:zlib');
fs.mkdirSync('public',{recursive:true});
const archive=fs.readFileSync('Miguel-Rafael-TCC.zip');
let count=0;
for(let p=0;p<archive.length-46;p++){
 if(archive.readUInt32LE(p)!==0x02014b50)continue;
 const method=archive.readUInt16LE(p+10),size=archive.readUInt32LE(p+20),nameSize=archive.readUInt16LE(p+28),extraSize=archive.readUInt16LE(p+30),commentSize=archive.readUInt16LE(p+32),offset=archive.readUInt32LE(p+42);
 const name=archive.subarray(p+46,p+46+nameSize).toString('utf8');
 p+=45+nameSize+extraSize+commentSize;
 if(!/\.(png|jpe?g|webp|gif|css)$/i.test(name))continue;
 if(name.includes('..')||name.includes('\\'))throw Error('Invalid archive path');
 const basename=path.posix.basename(name);
 const start=offset+30+archive.readUInt16LE(offset+26)+archive.readUInt16LE(offset+28);
 const packed=archive.subarray(start,start+size);
 const data=method===0?packed:method===8?zlib.inflateRawSync(packed):null;
 if(!data)throw Error('Unsupported ZIP compression');
 if(data.length>25000000)throw Error('Asset too large');
 fs.writeFileSync(path.join('public',basename),data);count++;
}
const pages=['pg_inicial.html','camietas.html','shorts.html','chuteiras.html','carrinho.html'];
for(const page of pages){
 let html=fs.readFileSync(page,'utf8').replaceAll('Pg-Inicial.html','index.html').replaceAll('Pg-Inicio.css','pg_inicial.css').replaceAll('camisetas.html','camietas.html').replaceAll('calcao.html   ','shorts.html').replaceAll('calcao.html','shorts.html');
 fs.writeFileSync('public/'+(page==='pg_inicial.html'?'index.html':page),html);
}
for(const name of ['pg_inicial.css','carrinho.js']) fs.copyFileSync(name,'public/'+name);
console.log('Extracted '+count+' image/style assets from TCC archive');
