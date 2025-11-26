
function atualizarCarrinho() {
    fetch('php/carrinho.php')
        .then(response => response.json())
        .then(data => {
            const carrinhoPainel = document.getElementById('carrinho-painel');
            let html = '<h4>Seu Pedido</h4>';
            
            if (data.itens && data.itens.length > 0) {
                html += '<ul>';
                data.itens.forEach(item => {
                    html += `<li>${item.quantidade} x ${item.nome} = R$ ${item.subtotal.toFixed(2)} 
                             <button onclick="removerItem(${item.id})">X</button></li>`;
                });
                html += '</ul>';
                html += `<p><strong>Total: R$ ${data.total.toFixed(2)}</strong></p>`;
                html += '<a href="carrinho.html" class="btn btn-success">Ir para Pagamento</a>';
            } else {
                html += '<p>Carrinho vazio</p>';
            }
            
            carrinhoPainel.innerHTML = html;
        });
}
function adicionarAoCarrinho(produtoId, quantidade) {
    fetch('php/adicionar_item.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `produto_id=${produtoId}&quantidade=${quantidade}`
    })
    .then(() => atualizarCarrinho());
}
function removerItem(produtoId) {
    fetch('php/remover_item.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `produto_id=${produtoId}`
    })
    .then(() => atualizarCarrinho());
}
setInterval(atualizarCarrinho, 3000);
document.addEventListener('DOMContentLoaded', atualizarCarrinho);
